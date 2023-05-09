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
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();



?>

        <div class="cb-pricing-calculator">
            <div class="cb-pricing-cal-heading">
                <h2>COMPLEXITY</h2>
            </div>
            <div class="cb-pricing-level">
                <label for="cbLow">
                    <input type="radio" onchange="cbGetRangeValue()" id="cbLow" name="cbPricingLevel" checked>
                    Low
                </label>
                <label for="cbmedium">
                    <input type="radio" onchange="cbGetRangeValue()"  id="cbmedium" name="cbPricingLevel">
                    Medium
                </label>
                <label for="cbhigh">
                    <input type="radio" onchange="cbGetRangeValue()"  id="cbhigh" name="cbPricingLevel">
                    High
                </label>
            </div>
            <div class="cb-pricing-cal-number-of-pages">
                <div class="cb-pricing-cal-pages-top">
                    <h2>NUMBER OF PAGES</h2>
                    <p id="cb-pricing-range-selected-page"></p>
                </div>
                <div class="cb-pricing-cal-range-slider">
                    <input id="cbPricingRangeSlider" type="range" min="1" max="10" step="1" value="3">
                    <div class="cb-pricing-cal-range-bottom">
                        <p id="cb-min-pages">1</p>
                        <p id="cb-max-pages">10</p>
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
            function cbGetSelectedPack(id) {
                return document.getElementById(id).checked;
            }

            function cbGetRangeValue() {
                // Get range value
                let cbGetRangeSliderValue = document.getElementById("cbPricingRangeSlider").value;

                // Get pages number selected
                let cbNumberOfPagesSelected = document.getElementById('cb-pricing-range-selected-page');
                let cbTotalPrice = document.getElementById('cbTotalPrice');

                // Set pages number to selected number from range value
                cbNumberOfPagesSelected.innerText = cbGetRangeSliderValue;



                // Price set based on package level
                let priceMultiplier = 100; // Default price multiplier for low package

                if (cbGetSelectedPack('cbmedium')) {
                    priceMultiplier = 200; // Update price multiplier for medium package
                } else if (cbGetSelectedPack('cbhigh')) {
                    priceMultiplier = 300; // Update price multiplier for high package
                }

                // Calculate and set the total price
                let totalPrice = cbGetRangeSliderValue * priceMultiplier;
                cbTotalPrice.innerText = totalPrice;
            }

            // Add event listener for input changes on the range slider
            document.getElementById("cbPricingRangeSlider").addEventListener('input', cbGetRangeValue);

           cbGetRangeValue();
        </script>

<?php
    }
}
