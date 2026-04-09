---
id: home
blueprint: pages
title: Home
template: pages/home
composition:
  -
    id: mnrian7v
    columns:
      -
        id: mnriao7p
        composition:
          -
            id: mnriar4r
            rich_text:
              -
                type: paragraph
                attrs:
                  textAlign: left
                content:
                  -
                    type: text
                    text: 'test column 1'
            type: rich_text
            enabled: true
        column_options:
          width: col-lg-3
          offset: offset-lg-3
        type: column
        enabled: true
      -
        id: mnriazga
        composition:
          -
            id: mnrib1n5
            rich_text:
              -
                type: paragraph
                attrs:
                  textAlign: left
                content:
                  -
                    type: text
                    text: 'Test Column 2'
            type: rich_text
            enabled: true
        column_options:
          width: col-lg-3
          offset: offset-lg-3
        type: column
        enabled: true
    columns_responsive_options:
      stack: lg
    type: columns
    enabled: true
  -
    id: mnri255z
    height: '100'
    unit: px
    responsive_options:
      display:
        - sm
        - md
        - lg
        - xl
    type: spacer
    enabled: true
  -
    id: mnrhzdlb
    table_headers: top
    table:
      -
        cells:
          - test
          - test1
          - test2
      -
        cells:
          - lorem
          - lorem1
          - lorem2
      -
        cells:
          - ipsum
          - ipsum1
          - ipsum2
      -
        cells:
          - hello
          - hello1
          - hello2
      -
        cells:
          - hi
          - hi1
          - hi2
    type: table
    enabled: true
  -
    id: mnrhseel
    video_type: internal
    video_ratio: 16x9
    internal_video: video.mp4
    popup: false
    type: video
    enabled: true
  -
    id: mnrhpczf
    rad_view: content/_form
    type: view
    enabled: true
  -
    id: mjgs13bq
    rich_text:
      -
        type: paragraph
        attrs:
          textAlign: left
        content:
          -
            type: text
            text: Darise
    type: rich_text
    enabled: true
  -
    id: mnh02evv
    wrap_options:
      enabled: true
    type: line
    enabled: true
  -
    id: mnh7kuif
    image: screenshot-2025-07-26-143515.png
    lightbox_options:
      disable_click_enlarge: false
      disable_caption: false
    image_options:
      caption: false
      alignment: center
      fit: contain
    link_options:
      new_tab: false
    type: image
    enabled: true
  -
    id: mk2m5t48
    button_text: Test
    link_type: url
    new_tab: true
    type: custom_button
    enabled: true
    url: 'https://mayonatvtour.com/'
composition_name: pages
show_in_nav: true
titlestrip_option: default
updated_by: 687eae95-1da6-45a1-a0a3-a15c62074aa2
updated_at: 1775740994
---
