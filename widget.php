<?php

namespace cbCownDownWidget;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class cbCownDown_Countdown_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cb-countdown-timer-widget';
    }

    public function get_title()
    {
        return __('CB Countdown', 'cb-countdown-timer');
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
            'cb-countdown-section_setting',
            [
                'label' => esc_html__('Countdown Settings', 'cb-countdown-timer'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cb_countDown_target_date',
            [
                'label' => esc_html__('Date and Time', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '2023-05-31 00:00:00',
            ]
        );

        $this->end_controls_section();

        // Content Tab End


        // Style Tab Start

        $this->start_controls_section(
            'cb_countdown_switch',
            [
                'label' => esc_html__('Switch', 'cb-countdown-timer'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cb-month-switch',
            [
                'label' => esc_html__('Months', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'cb-countdown-timer'),
                'label_off' => esc_html__('Off', 'cb-countdown-timer'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'cb-days-switch',
            [
                'label' => esc_html__('Days', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'cb-countdown-timer'),
                'label_off' => esc_html__('Off', 'cb-countdown-timer'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'cb-hours-switch',
            [
                'label' => esc_html__('Hours', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'cb-countdown-timer'),
                'label_off' => esc_html__('Off', 'cb-countdown-timer'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'cb-minutes-switch',
            [
                'label' => esc_html__('Minutes', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'cb-countdown-timer'),
                'label_off' => esc_html__('Off', 'cb-countdown-timer'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'cb-seconds-switch',
            [
                'label' => esc_html__('Seconds', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'cb-countdown-timer'),
                'label_off' => esc_html__('Off', 'cb-countdown-timer'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->end_controls_section();

        // Style Tab End

        $this->start_controls_section(
            'cb-coundown_style_section',
            [
                'label' => esc_html__('Style', 'cb-countdown-timer'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cb_counDown_text_typography',
                'selector' => '{{WRAPPER}} .cb-countdown-timer p',
            ]
        );

        $this->add_control(
            'cb_coundown_text_color',
            [
                'label' => esc_html__('Text Color', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb-countdown-timer p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cb_counDown_number_typography',
                'selector' => '{{WRAPPER}} .cb-countdown-timer p span',
            ]
        );

        $this->add_control(
            'cb_coundown_number_color',
            [
                'label' => esc_html__('Number Color', 'cb-countdown-timer'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb-countdown-timer p span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cb_countdown_gap',
            [
                'label' => esc_html__('Gap', 'textdomain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 100,
                'step' => 5,
                'default' => 15,
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $target_date = $settings['cb_countDown_target_date'];

        // unique id generated for each widget
        $unique_id = uniqid('countdown_');
        $function_name = 'cbUpdateCountdown_' . $unique_id;


?>

        <div class="cb-countdown-timer-widget-area">
            <div id="<?php echo esc_attr($unique_id); ?>" class="cb-countdown-timer" style="gap:<?php echo esc_attr($settings['cb_countdown_gap']); ?>px"></div>
        </div>

        <script>
            jQuery(document).ready(function($) {

                var targetDate = new Date("<?php echo esc_js($target_date); ?>").getTime();

                var countdownId = "<?php echo esc_js($unique_id); ?>";

                var <?php echo esc_js($function_name); ?> = setInterval(function() {
                    cbUpdateCountdown(countdownId);
                }, 1000);


                var countdownInterval = setInterval(cbUpdateCountdown, 1000);

                function cbUpdateCountdown(countdownId) {
                    var currentDate = new Date().getTime();
                    var timeRemaining = targetDate - currentDate;


                    // month checked if enabled from elementor switch panel
                    <?php if ('yes' === $settings['cb-month-switch']) : ?>
                        var months = Math.floor(timeRemaining / (1000 * 60 * 60 * 24 * 30));
                    <?php else : ?>
                        var months = '';
                    <?php endif ?>

                    // days checked if enabled from elementor switch panel
                    <?php if ('yes' === $settings['cb-days-switch']) : ?>
                        var days = Math.floor((timeRemaining % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
                    <?php else : ?>
                        var days = '';
                    <?php endif ?>

                    // hours checked if enabled from elementor switch panel
                    <?php if ('yes' === $settings['cb-hours-switch']) : ?>
                        var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    <?php else : ?>
                        var hours = '';
                    <?php endif ?>

                    // minutes checked if enabled from elementor switch panel
                    <?php if ('yes' === $settings['cb-minutes-switch']) : ?>
                        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    <?php else : ?>
                        var minutes = '';
                    <?php endif ?>

                    // seconds checked if enabled from elementor switch panel
                    <?php if ('yes' === $settings['cb-seconds-switch']) : ?>
                        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                    <?php else : ?>
                        var seconds = '';
                    <?php endif ?>



                    // var days = Math.floor((timeRemaining % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
                    // var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    // var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    // var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);


                    var monthMarkup = months !== '' ? '<p class="cb-countdown-timer-month">' + (months || '0') + '<span> Months</span></p>' : '';
                    var daysMarkup = days !== '' ? '<p class="cb-countdown-timer-days">' + (days || '0') + '<span> Days</span></p>' : '';
                    var hoursMarkup = hours !== '' ? '<p class="cb-countdown-timer-hours">' + (hours || '0') + '<span> Hours</span></p>' : '';
                    var minMarkup = minutes !== '' ? '<p class="cb-countdown-timer-minutes">' + (minutes || '0') + '<span> Minutes</span></p>' : '';
                    var secondMarkup = seconds !== '' ? '<p class="cb-countdown-timer-seconds">' + (seconds || '0') + '<span> Seconds</span></p>' : '';



                    var totalDueTimeWithMarkup = monthMarkup + daysMarkup + hoursMarkup + minMarkup + secondMarkup;

                    // var countdownText = months + " months, " + days + " days, " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds";

                    // var countdownText = months + " " + cbCountDown_translate('months') + ", " + days + " " + cbCountDown_translate('days') + ", " + hours + " " + cbCountDown_translate('hours') + ", " + minutes + " " + cbCountDown_translate('minutes') + ", " + seconds + " " + cbCountDown_translate('seconds');

                    $('#<?php echo esc_attr($unique_id); ?>').html(totalDueTimeWithMarkup);

                    if (timeRemaining <= 0) {
                        clearInterval(countdownInterval);
                        $('#countdown').text('Countdown expired');
                    }

                }
            });
        </script>


<?php
    }
}
