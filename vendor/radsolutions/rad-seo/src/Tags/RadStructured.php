<?php

namespace RadSolutions\RadSeo\Tags;

use Illuminate\Support\Arr;
use Statamic\Facades\GlobalSet;
use Statamic\Tags\Tags;
use Statamic\View\View;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\Schema;

class RadStructured extends Tags
{
    /**
     * The {{ rad_structured }} tag.
     */
    public function index()
    {
        $data = GlobalSet::findByHandle('structured_info')?->inCurrentSite()?->data();

        if (is_null($data) || !isset($data['business_name'])) {
            return '';
        }

        $graph = new Graph();

        $graph->webSite()
            ->name($data['business_name'] ?? null)
            ->url(config('app.url'))
            ->description($data['website_description'] ?? null);

        $this->buildCommon($graph->organization(), $data);

        $locations = collect($data['locations'] ?? [])
            ->filter(fn ($location) => (bool) ($location['enabled'] ?? true))
            ->values();

        if ($locations->count() === 1) {
            $location = $locations->first();
            $graph->add($this->buildListing($location));
            $this->buildCommon($graph->localBusiness(), $data);
        } else {
            foreach ($locations as $location) {
                $graph->add(
                    $this->buildListing($location, $data['business_name'] ?? null),
                    $location['name'] ?? null
                );
            }
        }

        return $graph->toScript();
    }

    protected function buildCommon(BaseType $entity, $data): void
    {
        $entity->name($data['business_name'] ?? null);
        $entity->url(config('app.url'));
        $entity->logo($this->buildImage());

        $sameAs = Arr::flatten($data['social'] ?? []);
        if (!empty($sameAs)) {
            $entity->setProperty('sameAs', $sameAs);
        }
    }

    protected function buildListing(array $data, ?string $parent = null): LocalBusiness
    {
        $business = new LocalBusiness();

        if (!is_null($parent)) {
            $business->name($data['name'] ?? null);
            $business->parentOrganization($parent);
        }

        $business->address($this->buildAddress($data));

        $geo = $this->buildCoordinates($data);
        if (!is_null($geo)) {
            $business->geo($geo);
        }

        if (!empty($data['phone'])) {
            $business->telephone($data['phone']);
        }

        if (!empty($data['email'])) {
            $business->email($data['email']);
        }

        $openingHours = $this->buildOpens($data);
        if (!is_null($openingHours)) {
            $business->openingHoursSpecification($openingHours);
        }

        $business->image($this->buildImage());

        return $business;
    }

    protected function buildImage(): ?string
    {
        $image = View::make('rad-seo::fragment._logo', [
            'logo' => config('rad-seo.opengraph-image', '/images/opengraph.png'),
        ])->render();

        return empty($image) ? null : $image;
    }

    protected function buildAddress(array $data)
    {
        $postalAddress = Schema::postalAddress();
        $streetAddressParts = array_filter([
            $data['street'] ?? null,
            $data['barangay'] ?? null,
        ]);
        $streetAddress = empty($streetAddressParts) ? null : implode(', ', $streetAddressParts);

        $postalAddress->streetAddress($streetAddress);
        $postalAddress->addressLocality($data['suburb'] ?? null);
        $postalAddress->addressRegion($data['state'] ?? null);
        $postalAddress->postalCode($data['postcode'] ?? null);
        $postalAddress->addressCountry($data['country'] ?? null);

        return count($postalAddress->toArray()) === 2 ? null : $postalAddress;
    }

    protected function buildCoordinates(array $data)
    {
        $geo = Schema::geoCoordinates();
        $geo->latitude($data['latitude'] ?? null);
        $geo->longitude($data['longitude'] ?? null);

        return count($geo->toArray()) === 2 ? null : $geo;
    }

    protected function buildOpens(array $data): ?array
    {
        if (!isset($data['opening_hours'])) {
            return null;
        }

        $opens = [];

        foreach ($data['opening_hours'] as $opening) {
            if (!(bool) ($opening['enabled'] ?? true)) {
                continue;
            }

            $open = Schema::openingHoursSpecification();
            $open->dayOfWeek($opening['days'] ?? null);
            $open->opens($opening['open'] ?? null);
            $open->closes($opening['close'] ?? null);

            if (count($open->toArray()) > 2) {
                $opens[] = $open;
            }
        }

        return empty($opens) ? null : $opens;
    }
}
