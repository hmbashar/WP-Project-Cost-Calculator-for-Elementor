<?php

namespace WPProjectCostCalculatorWidget;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class wp_Project_Cost_Calculator_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'wp-project-cost-calculator-widget';
    }

    public function get_title()
    {
        return __('Cost Calculator', 'cb-countdown-timer');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['general'];
    }


    protected function register_controls()
    {

        // Content Tab Start
        $this->start_controls_section(
			'wp_cost_calculator_content_section',
			[
				'label' => esc_html__( 'Pages', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'wp_cost_calculator_currency',
			[
				'label' => esc_html__( 'Currency', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'textdomain' ),
				'placeholder' => esc_html__( 'Input your Currency Symbol', 'textdomain' ),
			]
		);

		$this->add_control(
			'wp_cost_cal_pages_list',
			[
				'label' => esc_html__( 'Pages List', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
                    [
						'name' => 'page_list',
						'label' => esc_html__( 'Title', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => esc_html__( 'Page #1' , 'textdomain' ),					
					],
                    [
                        'name' => 'wp_cost_calculator_pack_1',
                        'label' => esc_html__( 'Package', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'wp_c_p_low',
                        'options' => [
                            'wp_c_p_low' => esc_html__( 'Low', 'textdomain' ),
                            'wp_c_p_medium'  => esc_html__( 'Medium', 'textdomain' ),
                            'wp_c_p_high' => esc_html__( 'High', 'textdomain' ),
                        ],
                    ], 
                    [
                        'name' => 'wp_cost_calculator_price_1',
                        'label' => esc_html__( 'Price', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'min' => 0,
                        'step' => 5,
                        'default' => 100,
                    ],
                    [
                        'name' => 'wp_cost_calculator_pack_2',
                        'label' => esc_html__( 'Package', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'wp_c_p_medium',
                        'options' => [
                            'wp_c_p_low' => esc_html__( 'Low', 'textdomain' ),
                            'wp_c_p_medium'  => esc_html__( 'Medium', 'textdomain' ),
                            'wp_c_p_high' => esc_html__( 'High', 'textdomain' ),
                        ],
                    ], 
                    [
                        'name' => 'wp_cost_calculator_price_2',
                        'label' => esc_html__( 'Price', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'min' => 0,
                        'step' => 5,
                        'default' => 200,
                    ],
                    [
                        'name' => 'wp_cost_calculator_pack_3',
                        'label' => esc_html__( 'Package', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'wp_c_p_high',
                        'options' => [
                            'wp_c_p_low' => esc_html__( 'Low', 'textdomain' ),
                            'wp_c_p_medium'  => esc_html__( 'Medium', 'textdomain' ),
                            'wp_c_p_high' => esc_html__( 'High', 'textdomain' ),
                        ],
                    ], 
                    [
                        'name' => 'wp_cost_calculator_price_3',
                        'label' => esc_html__( 'Price', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'min' => 0,
                        'step' => 5,
                        'default' => 400,
                    ],
				],
				'default' => [
					[
						'page_list' => esc_html__( 'Page #1', 'textdomain' ),
					],
				],
				'title_field' => '{{{ page_list }}}',
			]
		);

		$this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $repeater_pages = $settings['wp_cost_cal_pages_list'];
        $totalPages = !empty($repeater_pages) ? count($repeater_pages) : 1;
        
        if ($repeater_pages) {
            $data = [];
        
            foreach ($repeater_pages as $index => $page) {
                $options = [
                    // 'wp_c_p_low' => esc_html__('Low', 'textdomain'),
                    // 'wp_c_p_medium' => esc_html__('Medium', 'textdomain'),
                    // 'wp_c_p_high' => esc_html__('High', 'textdomain'),

                    'wp_c_p_low' => 'wp_c_p_low',
                    'wp_c_p_medium' => 'wp_c_p_medium',
                    'wp_c_p_high' => 'wp_c_p_high',
                ];
        
                $selected_keys = [
                    $page['wp_cost_calculator_pack_1'],
                    $page['wp_cost_calculator_pack_2'],
                    $page['wp_cost_calculator_pack_3'],
                ];
        
                $package_prices = [
                    $page['wp_cost_calculator_price_1'],
                    $page['wp_cost_calculator_price_2'],
                    $page['wp_cost_calculator_price_3'],
                ];
        
                $stepData = [];
                $array_number = $index + 1;

                foreach ($selected_keys as $keyIndex => $selected_key) {
                    if (isset($options[$selected_key])) {
                        $selected_text = $options[$selected_key];
                        $package_price = isset($package_prices[$keyIndex]) ? $package_prices[$keyIndex] : '';
        
                        $stepData[] = [
                            'step' => $array_number,
                            'package' => $selected_text,
                            'price' => $package_price,
                        ];
                    }
                }
        
                $data[] = $stepData;
            }
        
            $jsonData = json_encode($data);
            echo "<script>var jsonData = $jsonData;</script>";
        }
        

?>
<script>
    console.log(jsonData);
</script>

        <div class="cb-pricing-calculator">
            <div class="cb-pricing-cal-heading">
                <h2>COMPLEXITY</h2>
            </div>
            <div class="cb-pricing-level">
                <label for="wp_c_p_low">
                    <input type="radio" onchange="cbGetRangeValue()" class='wp_cost_calculator_package' id="wp_c_p_low" name="cbPricingLevel" checked value="wp_c_p_low">
                    Low
                </label>
                <label for="wp_c_p_medium">
                    <input type="radio" onchange="cbGetRangeValue()"  class='wp_cost_calculator_package' id="wp_c_p_medium" name="cbPricingLevel" value="wp_c_p_medium">
                    Medium
                </label>
                <label for="wp_c_p_high">
                    <input type="radio" onchange="cbGetRangeValue()"  class='wp_cost_calculator_package' id="wp_c_p_high" name="cbPricingLevel" value="wp_c_p_high">
                    High
                </label>
            </div>
            <div class="cb-pricing-cal-number-of-pages">
                <div class="cb-pricing-cal-pages-top">
                    <h2>NUMBER OF PAGES</h2>
                    <p id="cb-pricing-range-selected-page"></p>
                </div>
                <div class="cb-pricing-cal-range-slider">
                    <input id="cbPricingRangeSlider" type="range" min="1" max="<?php echo $totalPages; ?>" step="1" value="3">
                    <div class="cb-pricing-cal-range-bottom">
                        <p id="cb-min-pages">1</p>
                        <p id="cb-max-pages"><?php echo $totalPages; ?></p>
                    </div>
                </div>
            </div>
            <div class="cb-pricing-cal-total-price">
                <p>Total</p>
                <p id="cb-total-price">$<span id="cbTotalPrice">790</span></p>
            </div>
            <div class="cb-pricing-cal-submit-button">
                <a href="">Send Request</a>
            </div>
        </div>


        <script>
            function cbGetRangeValue() {
                // Get range value
                let cbGetRangeSliderValue = document.getElementById("cbPricingRangeSlider").value;

                // Get selected package
                let selectedPackage = '';
                const packageRadios = document.getElementsByClassName('wp_cost_calculator_package');
                for (let i = 0; i < packageRadios.length; i++) {
                    if (packageRadios[i].checked) {
                        selectedPackage = packageRadios[i].value;
                        break;
                    }
                }

                // Get pages number selected
                let cbNumberOfPagesSelected = document.getElementById('cb-pricing-range-selected-page');
                let cbTotalPrice = document.getElementById('cbTotalPrice');

                // Set pages number to selected number from range value
                cbNumberOfPagesSelected.innerText = cbGetRangeSliderValue;

                // Check if cbGetRangeSliderValue and selectedPackage match any 'jsonData' step and package value
                let matchedStep = null;
                jsonData.forEach(stepData => {
                    stepData.forEach(step => {
                        if (step.step == cbGetRangeSliderValue && step.package == selectedPackage) {
                            matchedStep = step;
                            return; // Exit the loop
                        }
                    });
                    if (matchedStep) {
                        return; // Exit the loop
                    }
                });

                if (matchedStep) {
                    console.log("cbGetRangeSliderValue and selected package match jsonData step and package value");
                    let price = parseInt(matchedStep.price); // Parse the price as an integer
                    console.log("Step: " + matchedStep.step + ", Package: " + matchedStep.package + ", Price: " + price);

                    // Calculate and set the total price
                    let totalPrice = price;
                    cbTotalPrice.innerText = totalPrice;
                } else {
                    console.log("cbGetRangeSliderValue and selected package do not match any jsonData step and package value");
                }
            }

            // Add event listener for input changes on the range slider
            document.getElementById("cbPricingRangeSlider").addEventListener('input', cbGetRangeValue);

            // Add event listener for change event on the package radios
            const packageRadios = document.getElementsByClassName('wp_cost_calculator_package');
            for (let i = 0; i < packageRadios.length; i++) {
                packageRadios[i].addEventListener('change', cbGetRangeValue);
            }

            // Initialize the calculations
            cbGetRangeValue();


        </script>

<?php
    }
}
