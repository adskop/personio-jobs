<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link hkvlaanderen.nl
 * @since 1.0.0
 *
 * @package Personio_Jobs
 * @subpackage Personio_Jobs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package Personio_Jobs
 * @subpackage Personio_Jobs/public
 * @author Hendrik Vlaanderen <h.k.vlaanderen@gmail.com>
 */
class Personio_Jobs_Public {

    private $plugin_name;


    private $version;


    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }


    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/personio-jobs-public.css', array(), $this->version, 'all' );

    }


    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/personio-jobs-public.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * @param $atts
     * @param $content
     * @return string
     */
    public function shortcode_handle( $atts, $content){

        $title = '';
        $department = '';
        $categorized = false;
        $layout = '';
        // Error Default.
        // Save $atts.
        $_atts = shortcode_atts( array(
            'categorized' => $categorized,
            'department' => $department,
            'layout' => $layout
        ), $atts );
        // Error.
        $_categorized = $_atts['categorized'];
        $_department = $_atts['department'];


        ob_start();
        $this->load_jobs();
        $_result = ob_get_clean();

        // Return the data.
        return $_result;
    }

    /**
     * @param string $lang
     * @param string $categorized
     */
    public function load_jobs($lang = 'en', $categorized = ''){

     /*
        $translations = $this->get_translations();

        // Print job postings

        $sortedJobs = $this->sortJobs($positions, $company, $d, $hostname, $translations, $lang);



        if($categorized){
            $this->display_jobs_by_department($sortedJobs);
        } else {
            $this->display_jobs_list($sortedJobs);
        }
*/
    }

    /**
     * @param $positions
     * @param $company
     * @param $d
     * @param $hostname
     * @param $translations
     * @param $lang
     */
    public function sortJobs($positions, $company, $d, $hostname, $translations, $lang){



        foreach ($positions as $position) :
            $detailLink = $d . $hostname . '.jobs.personio.de/job/' . $position->id;
            // if ($_GET["channel"]) {
            // $detailLink .= '?_pc=' . $_GET["channel"];
            // }


            if ($position->subcompany == $company) :

                // recreate the datafeed to what we need no?

                $job_array[] = array(
                    'department' => (string)$position->department,
                    'position' => array(
                        'name' => (string)$position->name,
                        'type' => $translations[(string)$position->employmentType][$lang],
                        'schedule' => $translations[(string)$position->schedule][$lang],
                        'detailLink' => $detailLink
                    ),
                );

            endif;
        endforeach;


        $sortedJobs = [];

        foreach ($job_array as $j)
        {
            $sortedJobs[$j['department']][] = $j;
        }

        return $sortedJobs;
    }


    /**
     * @param $sortedJobs
     *
     */
    public function display_jobs_list($sortedJobs){

        foreach($sortedJobs as $jobs => $job):


            foreach($job as $j):

                var_dump($j);
                //$single_template = plugin_dir_path(__FILE__) . 'partials/personio-jobs-public-job.php';

                //include($single_template);

                ?>
                <a class="job-button" target="_blank" href="<?= $j['position']['detailLink'] ?>">
                    <span><?= $j['position']['name'] ?></span>
                </a>

            <?php

            endforeach;

        endforeach;

    }

    /**
     * @param $sortedJobs
     */
    public function display_jobs_by_department($sortedJobs){



        foreach($sortedJobs as $jobs => $job): ?>
            <div class="row">
                <h4 class="text-left"><?= $jobs ?></h4>
            </div>

            <?php foreach($job as $j): ?>
                <div class="row job">
                    <?php
                    //$single_template = plugin_dir_path(__FILE__) . 'partials/personio-jobs-public-job.php';

                    //include($single_template);
                    ?>
                    <a class="job-button" target="_blank" href="<?= $j['position']['detailLink'] ?>">
                        <span><?= $j['position']['name'] ?></span>
                    </a>


                </div>

            <?php endforeach; ?>

        <?php endforeach;

    }

    public function get_translations(){

        $translations = [
            "full-time" => [
                "de" => "Vollzeit",
                "en" => "Full-time"
            ],
            "part-time" => [
                "de" => "Teilzeit",
                "en" => "Part-time"
            ],
            "permanent" => [
                "de" => "Festanstellung",
                "en" => "Permanent Employment"
            ],
            "intern" => [
                "de" => "Praktikum",
                "en" => "Internship"
            ],
            "trainee" => [
                "de" => "Trainee Stelle",
                "en" => "Trainee Stelle"
            ],
            "freelance" => [
                "de" => "Freelance Position",
                "en" => "Freelance Position"
            ],
        ];

        return $translations;
    }


    public function is_wpml_active(){

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // check for plugin using plugin name
        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
            //plugin is activated
            return true;
        } else {
            return false;
        }
    }

}
