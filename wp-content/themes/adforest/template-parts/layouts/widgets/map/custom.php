<?php
if (isset($_GET['cat_id']) && $_GET['cat_id'] != "" && is_numeric($_GET['cat_id'])) {

    $term_id = $_GET['cat_id'];
    $result = adforest_dynamic_templateID($term_id);
    $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);

    if (isset($templateID) && $templateID != "") {
        $formData = sb_dynamic_form_data($templateID);
        $customHTML .= '';
        foreach ($formData as $r) {


            if (isset($r['types']) && trim($r['types']) != "") {
                if (isset($r['types']) && $r['types'] == 5) {
                    continue;
                }
                $in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
                if ($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1) {

                    if (isset($r['types']) && $r['types'] == 6) {
                        $mycols = 'col-md-6 col-xs-12 col-sm-6';
                    } else if (isset($r['types']) && $r['types'] == 4) {
                        $mycols = 'col-md-8 col-xs-12 col-sm-12 custom-date-min-max';
                    } else if (isset($r['types']) && $r['types'] == 9) {
                        $mycols = 'col-md-12 col-xs-12 col-sm-12';
                    } else if (isset($r['types']) && $r['types'] == 8) {
                        $mycols = 'col-md-12 col-xs-12 col-sm-12';
                    } else {
                        $mycols = 'col-md-4 col-xs-12 col-sm-4';
                    }

                    $customHTML .= adforest_advance_search_map_container_open(true);
                    
                    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);

                    $customHTML .= '<div class="' . $mycols . '">

<div class="form-group">
<form method="get" action="' . get_the_permalink($sb_search_page) . '">

      <label>' . esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])) . ' ' . esc_html($r['titles']) . '</label>';
                    $fieldName = "custom[" . esc_attr($r['slugs']) . "]";
                    $fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][esc_attr($r['slugs'])])) ? $_GET['custom'][esc_attr($r['slugs'])] : '';
                    if (isset($r['types']) && $r['types'] == 1) {
                        $customHTML .= '<div class="input-group add-on"><input placeholder="' . esc_attr($r['titles']) . '" name="' . $fieldName . '" value="' . $fieldValue . '" type="text" class="form-control" /><div class="input-group-btn">
        <button class="btn btn-default custom_padding" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>';
                    }
                    if (isset($r['types']) && $r['types'] == 2) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != "") {
                            $varArrs = @explode("|", $r['values']);
                            $options .= '<option value="0">' . esc_html__("Select Option", "adforest") . '</option>';
                            foreach ($varArrs as $varArr) {
                                $selected = ($fieldValue == $varArr) ? 'selected="selected"' : '';
                                $options .= '<option value="' . esc_attr($varArr) . '" ' . $selected . '>' . esc_html($varArr) . '</option>';
                            }
                        }
                        $customHTML .= '<select name="' . $fieldName . '" class="submit_on_select" >' . $options . '</select>';
                    }

                    if (isset($r['types']) && $r['types'] == 3) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != "") {
                            $varArrs = @explode("|", $r['values']);

                            $loop = 1;
                            if (count($varArrs) > 0) {
                                $options = '<select name="' . $fieldName . '" class="submit_on_select"><option></option>';
                            }
                            foreach ($varArrs as $val) {

                                $checked = '';
                                if (isset($fieldValue) && $fieldValue != "") {
                                    //$checked = in_array($val, $fieldValue) ? 'checked="checked"' : '';
                                    $checked = ($val == $fieldValue) ? 'selected="selected"' : '';
                                }
                                //$checked = ( $val == $fieldValue) ? 'checked="checked"' : '';     
                                //$options .= '<li><input type="checkbox" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'['.$val.']"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';


                                $options .= '<option value="' . $val . '"' . $checked . '>' . esc_html($val) . '</option>';
                                $loop++;
                            }
                            $options .= '</select>';
                        }
                        //$customHTML .= '<select name="'.$fieldName.'" class="custom-search-select" >'.$options.'</select>';    
                        $customHTML .= '<div class="skin-minimal"><ul class="list">' . $options . '</ul></div>';
                    }
                    /* if( isset($r['types'] ) && $r['types'] == 3 )
                      {
                      $options = '';
                      if(isset($r['values'] ) && $r['values'] != '')
                      {
                      $fieldName = "custom[".esc_attr($r['slugs'])."]";
                      $varArrs = @explode("|", $r['values']);

                      $loop = 1;
                      foreach($varArrs as $val)
                      {

                      $checked = '';
                      if( isset( $fieldValue ) && $fieldValue != "")
                      {
                      if( isset($fieldValue) && is_array( $fieldValue ) ){
                      $checked = (in_array($val, $fieldValue)) ? 'checked="checked"' : '';
                      }
                      else{	$checked = ($val == $fieldValue) ? 'checked="checked"' : '';  }

                      }

                      $options .= '<li><input type="radio" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
                      $loop++;
                      }
                      }
                      $customHTML .= '<div class="skin-minimal"><ul class="list">'.$options.'</ul></div>';
                      } */

                    if (isset($r['types']) && $r['types'] == 9) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != '') {
                            $fieldName = "custom[" . esc_attr($r['slugs']) . "]";
                            $varArrs = @explode("|", $r['values']);

                            $loop = 1;
                            foreach ($varArrs as $val) {

                                $checked = '';
                                if (isset($fieldValue) && $fieldValue != "") {
                                    if (isset($fieldValue) && is_array($fieldValue)) {
                                        $checked = (in_array($val, $fieldValue)) ? 'checked="checked"' : '';
                                    } else {
                                        $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
                                    }
                                }

                                $options .= '<li><input type="checkbox" id="minimal-checkbox-' . $loop . '"  value="' . esc_html($val) . '" ' . $checked . ' name="' . $fieldName . '[]"><label for="minimal-checkbox-' . $loop . '">' . esc_html($val) . '</label></li>';
                                $loop++;
                            }
                        }
                        $customHTML .= '<div class=" custom-checkboxes"><div class="skin-minimal"><ul class="list">' . $options . '</ul></div></div>';
                    }


                    if (isset($r['types']) && $r['types'] == 4) {

                        $minVal = (isset($_GET["min_custom"]) && isset($_GET['min_custom'][esc_attr($r['slugs'])])) ? $_GET['min_custom'][esc_attr($r['slugs'])] : '';
                        $maxVal = (isset($_GET["max_custom"]) && isset($_GET['max_custom'][esc_attr($r['slugs'])])) ? $_GET['max_custom'][esc_attr($r['slugs'])] : '';

                        $btn_cls = 'btn btn-theme btn-sm btn-block';
                        $customHTML .= '<div class="clearfix"></div><div class="search-widget col-md-5 no-padding"><input placeholder="' . esc_attr(__("From", "adforest")) . '" name="min_' . $fieldName . '" value="' . $minVal . '" type="text" class="dynamic-form-date-fields"><button type="submit" onclick="return false;"><i class="fa fa-calendar"></i></button></div><div class="search-widget col-md-5 no-padding"><input placeholder="' . esc_attr(__("To", "adforest")) . '" name="max_' . $fieldName . '" value="' . $maxVal . '" type="text" class="dynamic-form-date-fields"><button type="submit" onclick="return false;"><i class="fa fa-calendar"></i></button></div>
				<div class="col-md-2 no-padding"><button type="submit" class="' . esc_attr($btn_cls) . '"><i class="fa fa-search"></i></button></div>';
                    }
                    /* Type 6 is for URL */
                    if (isset($r['types']) && $r['types'] == 6) {
                        $minVal = (isset($_GET["min_custom"]) && isset($_GET['min_custom'][esc_attr($r['slugs'])])) ? $_GET['min_custom'][esc_attr($r['slugs'])] : "";
                        $maxVal = (isset($_GET["max_custom"]) && isset($_GET['max_custom'][esc_attr($r['slugs'])])) ? $_GET['max_custom'][esc_attr($r['slugs'])] : "";

                        $btn_cls = 'btn btn-theme btn-sm btn-block margin-top-10';

                        /* Values */
                        $varArrs = @explode("|", $r['values']);
                        $hiddenMin = ( isset($varArrs[0]) && (int) $varArrs[0] ) ? $varArrs[0] : 0;
                        $hiddenMax = ( isset($varArrs[1]) && (int) $varArrs[1] ) ? $varArrs[1] : 100000;
                        $hiddenStp = ( isset($varArrs[2]) && (int) $varArrs[2] ) ? $varArrs[2] : 1;

                        $customHTML .= '<span class="price-slider-value"><strong>' . __('Range', 'adforest') . ': </strong> 
					<span id="price-min-' . $r['slugs'] . '"></span> - <span id="price-max-' . $r['slugs'] . '"></span> </span>				
					 <div id="price-slider-' . $r['slugs'] . '"></div>
					 <div class="input-group margin-top-10">
					<input type="text" class="form-control" name="min_' . $fieldName . '" value="' . esc_attr($minVal) . '" placeholder="' . __('min', 'adforest') . '" id="min_selected-' . $r['slugs'] . '" />
					<span class="input-group-addon">-</span>
					<input type="text" class="form-control" name="max_' . $fieldName . '" value="' . esc_attr($maxVal) . '" placeholder="' . __('max', 'adforest') . '" id="max_selected-' . $r['slugs'] . '" />
					</div><input type="submit" class="' . esc_attr($btn_cls) . '" value="' . __('Search', 'adforest') . '" />
				  <input type="hidden" id="min_' . $r['slugs'] . '" value="' . $hiddenMin . '" />
				  <input type="hidden" id="max_' . $r['slugs'] . '" value="' . $hiddenMax . '" />
					
					<script>
					(function($) {
									"use strict";
								$(document).ready(function($) {	 
									 var min_price	=	$("#min_' . $r['slugs'] . '").val();
									 var max_price	=	$("#max_' . $r['slugs'] . '").val();
									 if( $("#min_' . $r['slugs'] . '").length > 0 )
									 {
									$("#price-slider-' . $r['slugs'] . '").noUiSlider({
										connect: true,
										behaviour: "tap",
										start: [min_price, max_price],
										step: ' . $hiddenStp . ',
										range: { "min": parseInt(min_price), "max": parseInt(max_price) }  });
										 
										$("#price-slider-' . $r['slugs'] . '").Link("lower").to($("#price-min-' . $r['slugs'] . '"), null, wNumb({ decimals: 0 }));
										$("#price-slider-' . $r['slugs'] . '").Link("lower").to($("#min_selected-' . $r['slugs'] . '"), null, wNumb({ decimals: 0 }));
										$("#price-slider-' . $r['slugs'] . '").Link("upper").to($("#price-max-' . $r['slugs'] . '"), null, wNumb({ decimals: 0 }));
										$("#price-slider-' . $r['slugs'] . '").Link("upper").to($("#max_selected-' . $r['slugs'] . '"), null, wNumb({ decimals: 0 }));
									 }
									});		
								})(jQuery);
					</script>
					';
                    }
                    /* Type 7 is for colors */
                    if (isset($r['types']) && $r['types'] == 7) {

                        $options = $myColors = '';
                        if (isset($r['values']) && $r['values'] != '') {
                            $varArrs = @explode("|", $r['values']);

                            $loop = $loop_count = 1;
                            $colorsCss = '';
                            $count_more = ( isset($varArrs) && count((array) $varArrs) > 6 ) ? ' more ' : ' no-more ';
                            foreach ($varArrs as $val) {
                                $checked = '';
                                if (isset($fieldValue) && $fieldValue != "") {
                                    $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
                                }

                                $colors = @explode(":", $val);

                                $code = ( isset($colors[0]) && $colors[0] != "" ) ? $colors[0] : '';
                                $name = ( isset($colors[1]) && $colors[1] != "" ) ? $colors[1] : '';

                                if ($code != "" && $name != "") {
                                    $is_checked = ($fieldValue == $code) ? 'checked="checked"' : '';
                                    $options .= '<div class="color-picker__item">
										<input id="input-' . $loop_count . '" type="radio" class="color-picker__input" name="' . $fieldName . '" value="' . esc_attr($code) . '" ' . $is_checked . ' onclick="this.form.submit()"/>
										<label for="input-' . $loop_count . '" class="color-picker__color  color-picker__color--' . $loop_count . '  ' . $count_more . '"></label>
									  </div>';
                                    $colorsCss .= '.color-picker__color--' . $loop_count . ' {  background: ' . $code . '; }';
                                    $loop_count++;
                                    $loop++;
                                }
                            }
                            $myColors = '<style>' . $colorsCss . '</style>';
                        }
                        $btn_cls = 'btn btn-theme btn-sm btn-block';
                        $customHTML .= '<div class="skin-minimal theme-input-colors">' . $options . '</div>' . $myColors;
                    }
                    /* Type 8 is for radio buttons */
                    if (isset($r['types']) && $r['types'] == 8) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != '') {
                            $varArrs = @explode("|", $r['values']);

                            $loop = 1;
                            foreach ($varArrs as $val) {

                                $checked = '';
                                if (isset($fieldValue) && $fieldValue != "") {
                                    $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
                                }

                                $options .= '<li><input type="radio" id="minimal-checkbox-' . $loop . '"  value="' . esc_html($val) . '" ' . $checked . ' name="' . $fieldName . '"><label for="minimal-checkbox-' . $loop . '">' . esc_html($val) . '</label></li>';
                                $loop++;
                            }
                        }
                        $customHTML .= '<div class="custom-radioboxes"><div class="skin-minimal"><ul class="list">' . $options . '</ul></div></div>';
                    }


                    $customHTML .= adforest_search_params($fieldName);
                    $customHTML .= '</form></div>';

                    $customHTML .= '</div>';
                    $customHTML .= '<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">' . adforest_widget_counter(true) . '</div>';
                    $customHTML .= adforest_advance_search_map_container_close(true);
                    $customHTML .= adforest_advance_search_container(true);
                }
            }
        }
    }
}
?>