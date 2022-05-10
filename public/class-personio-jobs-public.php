<?php
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

    public function load_jobs(){
        $IDs = getWordPressIDs();
        $Research = array();
        $Next = array();
        $Connect = array();
        $Nova = array();
        $Elements = array();
        $View = array();
        $permanent = array();
        $intern = array();
        $work_stud = array();
        $trainee = array();
        $temporary = array();
        $getFilter = get_option('personio-filter');

        foreach ($IDs as $ID){
            $title = getPostTitle($ID);
            $url = getPostURL($ID);
            $joboffice = getOffice($ID);
            $jobsubcompany = getSubcompany($ID);
            $jobRC = getRecruitingCategory($ID);
            $jobET = getEmploymentType($ID);
            $jobSchedule = getSchedule($ID);

            if($jobSchedule == 'full-time'){
                $jobSchedule = 'Vollzeit';
            }elseif($jobSchedule == 'part-time'){
                $jobSchedule = 'Teilzeit';
            }

            if($jobET == 'permanent'){
                $jobET = 'Festanstellung';
            }elseif($jobET == 'intern'){
                $jobET = 'Praktikum/Studentenjob';
            }elseif($jobET == 'working_student'){
                $jobET = 'Werkstudierende';
            }elseif($jobET == 'trainee'){
                $jobET = 'Ausbildung/Trainee';
            }elseif($jobET == 'temporary'){
                $jobET = 'Befristet';
            }

            $link = '<div class=joblink><a href="'.$url.'">'.$title."<br><small> $jobET, $jobSchedule · $joboffice </small>".'</a></div>';

            if ($getFilter == 1){
                if($jobsubcompany == 'SKOPOS GmbH & Co. KG'){
                    array_push($Research,$link );
                }elseif($jobsubcompany == 'SKOPOS NEXT GmbH & Co. KG'){
                    array_push($Next,$link );
                }elseif($jobsubcompany == 'SKOPOS CONNECT GmbH'){
                    array_push($Connect,$link );
                }elseif($jobsubcompany == 'SKOPOS NOVA GmbH'){
                    array_push($Nova,$link );
                }elseif($jobsubcompany == 'SKOPOS ELEMENTS GmbH'){
                    array_push($Elements,$link );
                }elseif($jobsubcompany == 'SKOPOS VIEW GmbH & Co. KG'){
                    array_push($View,$link );
                }
            }else{
                if($jobET == 'Festanstellung'){
                    array_push($permanent,$link );
                }elseif($jobET == 'Praktikum/Studentenjob'){
                    array_push($intern,$link );
                }elseif($jobET == 'Werkstudierende'){
                    array_push($work_stud,$link );
                }elseif($jobET == 'Ausbildung/Trainee'){
                    array_push($trainee,$link );
                }elseif($jobET == 'Befristet'){
                    array_push($temporary,$link );
                }
            }


        }

        ?>
        <div id="career-jobs"></div>
        <script>
jQuery(document).ready(function(){
  jQuery("#Filter1").click(function(){
    jQuery('div[id^="Job1"]').show(500);
      jQuery('div[id^="Job2"]').hide(500);
      jQuery('div[id^="Job3"]').hide(500);
      jQuery('div[id^="Job4"]').hide(500);
      jQuery('div[id^="Job5"]').hide(500);
      jQuery('div[id^="Job6"]').hide(500);
  });
});
</script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter2").click(function(){
                    jQuery('div[id^="Job2"]').show(500);
                    jQuery('div[id^="Job1"]').hide(500);
                    jQuery('div[id^="Job3"]').hide(500);
                    jQuery('div[id^="Job4"]').hide(500);
                    jQuery('div[id^="Job5"]').hide(500);
                    jQuery('div[id^="Job6"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter3").click(function(){
                    jQuery('div[id^="Job3"]').show(500);
                    jQuery('div[id^="Job1"]').hide(500);
                    jQuery('div[id^="Job2"]').hide(500);
                    jQuery('div[id^="Job4"]').hide(500);
                    jQuery('div[id^="Job5"]').hide(500);
                    jQuery('div[id^="Job6"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter4").click(function(){
                    jQuery('div[id^="Job4"]').show(500);
                    jQuery('div[id^="Job1"]').hide(500);
                    jQuery('div[id^="Job2"]').hide(500);
                    jQuery('div[id^="Job3"]').hide(500);
                    jQuery('div[id^="Job5"]').hide(500);
                    jQuery('div[id^="Job6"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter5").click(function(){
                    jQuery('div[id^="Job5"]').show(500);
                    jQuery('div[id^="Job1"]').hide(500);
                    jQuery('div[id^="Job2"]').hide(500);
                    jQuery('div[id^="Job3"]').hide(500);
                    jQuery('div[id^="Job4"]').hide(500);
                    jQuery('div[id^="Job6"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter6").click(function(){
                    jQuery('div[id^="Job6"]').show(500);
                    jQuery('div[id^="Job1"]').hide(500);
                    jQuery('div[id^="Job2"]').hide(500);
                    jQuery('div[id^="Job3"]').hide(500);
                    jQuery('div[id^="Job4"]').hide(500);
                    jQuery('div[id^="Job5"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#all-filter").click(function(){
                    jQuery('div[id^="Job6"]').show(500);
                    jQuery('div[id^="Job1"]').show(500);
                    jQuery('div[id^="Job2"]').show(500);
                    jQuery('div[id^="Job3"]').show(500);
                    jQuery('div[id^="Job4"]').show(500);
                    jQuery('div[id^="Job5"]').show(500);
                    jQuery('div[id^="Job7"]').show(500);
                    jQuery('div[id^="Job8"]').show(500);
                    jQuery('div[id^="Job9"]').show(500);
                    jQuery('div[id^="Job10"]').show(500);
                    jQuery('div[id^="Job11"]').show(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter7").click(function(){
                    jQuery('div[id^="Job7"]').show(500);
                    jQuery('div[id^="Job8"]').hide(500);
                    jQuery('div[id^="Job9"]').hide(500);
                    jQuery('div[id^="Job10"]').hide(500);
                    jQuery('div[id^="Job11"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter8").click(function(){
                    jQuery('div[id^="Job8"]').show(500);
                    jQuery('div[id^="Job7"]').hide(500);
                    jQuery('div[id^="Job9"]').hide(500);
                    jQuery('div[id^="Job10"]').hide(500);
                    jQuery('div[id^="Job11"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter9").click(function(){
                    jQuery('div[id^="Job9"]').show(500);
                    jQuery('div[id^="Job7"]').hide(500);
                    jQuery('div[id^="Job8"]').hide(500);
                    jQuery('div[id^="Job10"]').hide(500);
                    jQuery('div[id^="Job11"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter10").click(function(){
                    jQuery('div[id^="Job10"]').show(500);
                    jQuery('div[id^="Job7"]').hide(500);
                    jQuery('div[id^="Job8"]').hide(500);
                    jQuery('div[id^="Job9"]').hide(500);
                    jQuery('div[id^="Job11"]').hide(500);
                });
            });
        </script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#Filter11").click(function(){
                    jQuery('div[id^="Job11"]').show(500);
                    jQuery('div[id^="Job7"]').hide(500);
                    jQuery('div[id^="Job8"]').hide(500);
                    jQuery('div[id^="Job9"]').hide(500);
                    jQuery('div[id^="Job10"]').hide(500);
                });
            });
        </script>


<?php
        echo '<button id="all-filter" class="btn btn-primary">Alle</button>';

        if($getFilter == 1) {
            echo '<button id="Filter1" class="btn btn-primary">SKOPOS GmbH & Co. KG</button>';
            echo '<button id="Filter2" class="btn btn-primary">SKOPOS NEXT GmbH & Co. KG</button>';
            echo '<button id="Filter3" class="btn btn-primary">SKOPOS CONNECT GmbH</button>';
            echo '<button id="Filter4" class="btn btn-primary">SKOPOS NOVA GmbH</button>';
            echo '<button id="Filter5" class="btn btn-primary">SKOPOS ELEMENTS GmbH</button>';
            echo '<button id="Filter6" class="btn btn-primary">SKOPOS VIEW GmbH & Co. KG</button>';

            echo '<div class="jobs-overview">';
            if(empty($Research) == false){
                echo '<div id="Job1" class="Job1">';
                echo'<h4>SKOPOS GmbH & Co. KG</h4>';
                foreach ($Research as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($Next) == false){
                echo '<div id ="Job2" class="Job2">';
                echo'<h4>SKOPOS NEXT GmbH & Co. KG</h4>';
                foreach ($Next as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($Connect) == false){
                echo '<div id ="Job3" class="Job3">';
                echo'<h4>SKOPOS CONNECT GmbH</h4>';
                foreach ($Connect as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($Nova) == false){
                echo '<div id ="Job4" class="Job4">';
                echo'<h4>SKOPOS NOVA GmbH</h4>';
                foreach ($Nova as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($Elements) == false){
                echo '<div id ="Job5" class="Job5">';
                echo'<h4>SKOPOS ELEMENTS GmbH</h4>';
                foreach ($Elements as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($View) == false){
                echo '<div id ="Job6" class="Job6">';
                echo'<h4>SKOPOS VIEW GmbH & Co. KG</h4>';
                foreach ($View as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            echo '</div>';

        }else{
            echo '<button id="Filter7" class="btn btn-primary">Ausbildung/Trainee</button>';
            echo '<button id="Filter11" class="btn btn-primary">Befristet</button>';
            echo '<button id="Filter8" class="btn btn-primary">Festanstellung</button>';
            echo '<button id="Filter9" class="btn btn-primary">Praktikum/Studentenjob</button>';
            echo '<button id="Filter10" class="btn btn-primary">Werkstudierende</button>';

            echo '<div class="jobs-overview">';
            if(empty($trainee) == false){
                echo '<div id="Job7" class="Job7">';
                echo'<h4>Ausbildung/Trainee</h4>';
                foreach ($trainee as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($temporary) == false){
                echo '<div id="Job11" class="Job11">';
                echo'<h4>Befristet</h4>';
                foreach ($temporary as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($permanent) == false){
                echo '<div id ="Job8" class="Job8">';
                echo'<h4>Festanstellung</h4>';
                foreach ($permanent as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($intern) == false){
                echo '<div id ="Job9" class="Job9">';
                echo'<h4>Praktikum/Studentenjob</h4>';
                foreach ($intern as $Job){
                    echo $Job;
                }
                echo '</div>';
            }
            if(empty($work_stud) == false){
                echo '<div id ="Job10" class="Job11">';
                echo'<h4>Werkstudierende</h4>';
                foreach ($work_stud as $Job){
                    echo $Job;
                }
                echo '</div>';
            }

            echo '</div>';



        }





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
