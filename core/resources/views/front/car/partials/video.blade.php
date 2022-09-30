
    <!-- Start finlance_banner section -->
    <section class="finlance_banner banner_v1">
        <div class="hero_slide_v1">
            <div class="single_slider bg_image lazy" id="hero-home-5" data-bg="{{asset('assets/front/img/'.$bs->hero_bg)}}" style="background-size:cover;">
                <div id="bgndVideo" data-property="{videoURL:'{{$bs->hero_section_video_link}}',containment:'#hero-home-5', quality:'large', autoPlay:true, loop:true, mute:true, opacity:1}"></div>
                <div class="bg_overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="banner_content">
                                <span style="font-size: {{$be->hero_section_title_font_size}}px">{{convertUtf8($bs->hero_section_title)}}</span>
                                <h1 data-animation="fadeInUp" data-delay=".2s" style="font-size: {{$be->hero_section_bold_text_font_size}}px">{{convertUtf8($bs->hero_section_bold_text)}}</h1>
                                <h3 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_text_font_size}}px">{{convertUtf8($bs->hero_section_text)}}</h3>
                                @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
                                    <a href="{{$bs->hero_section_button_url}}" class="finlance_btn" data-animation="fadeInUp" data-delay=".4s" style="font-size: {{$be->hero_section_button_text_font_size}}px">{{convertUtf8($bs->hero_section_button_text)}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End finlance_banner section -->

