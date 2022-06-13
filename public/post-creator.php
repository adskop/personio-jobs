<?php
function cron_job_task(){
    $logcontent = "";
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
            $lang = ICL_LANGUAGE_CODE; // Depending on implementation of multilingual content
        }

    $hostname = get_option('personio-host');
    $company = get_option('personio-company');
    $categorized = get_option('personio-categorized');

    if (is_ssl()) {
        $d = 'https://';
    } else {
        $d = 'http://';
    }

    require_once('post-creator1.php');

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $path = $d . $hostname . '.jobs.personio.de/xml?language=' . $lang;
    $positions = simplexml_load_file($path);

    $arrayPersonioIDsinWordPress = getPersonioIDs();

    $arrayXMLPersonio = array();
    $y = 0;
    foreach ($positions as $position){
        array_push($arrayXMLPersonio, $positions->position->$y->id);
        $y++;
    }

    $i = 0;
    foreach ($positions as $position) {
        $content = '';
        $jobET = '';
        $jobSchedule = '';
        $jobRegion = '';
        $jobPostalAddress = '';
        $jobPostalCode = '';
        $id = $positions->position->$i->id;
        $subcompany = $positions->position->$i->subcompany;
        $office = $positions->position->$i->office;
        $department = $positions->position->$i->department;
        $recruitingCategory = $positions->position->$i->recruitingCategory;
        $name = $positions->position->$i->name;
        $employmentType = $positions->position->$i->employmentType;
        $seniority = $positions->position->$i->seniority;
        $schedule = $positions->position->$i->schedule;
        $yearsOfExperience = $positions->position->$i->yearsOfExperience;
        $keywords = $positions->position->$i->keywords;
        $occupation = $positions->position->$i->occupation;
        $occupationCategory = $positions->position->$i->occupationCategory;
        $createdAt = $positions->position->$i->createdAt;

        if($office == "Hürth"){
            $jobRegion = 'Nordrhein-Westfalen';
            $jobPostalAddress = 'Hans-Böckler-Str. 163';
            $jobPostalCode = ' 50354';
        }elseif($office == "Aachen"){
            $jobRegion = 'Nordrhein-Westfalen';
            $jobPostalAddress = 'Oppenhoffallee 106';
            $jobPostalCode = '52066';
        }elseif($office == "München"){
            $jobRegion = 'Bayern';
            $jobPostalAddress = 'Kaufingerstraße 24';
            $jobPostalCode = '80331';
        }else{
            $jobRegion = 'Nordrhein-Westfalen';
            $jobPostalAddress = 'Hans-Böckler-Str. 163';
            $jobPostalCode = ' 50354';
        }

        if($schedule == 'full-time'){
            $jobSchedule = 'Vollzeit';
        }elseif($schedule == 'part-time'){
            $jobSchedule = 'Teilzeit';
        }

        if($employmentType == 'permanent'){
            $jobET = 'Festanstellung';
        }elseif($employmentType == 'intern'){
            $jobET = 'Praktikum/Studentenjob';
        }elseif($employmentType == 'working_student'){
            $jobET = 'Werkstudierende';
        }elseif($employmentType == 'trainee'){
            $jobET = 'Ausbildung/Trainee';
        }elseif($employmentType == 'temporary'){
            $jobET = 'Befristet';
        }

        $path = get_home_url()."/wp-content/plugins/personio-jobs/public/personio_job_pic1.png";
        $careerpage = get_option('personio-career-page');

        $content.= "<div id='hide' class='hide'>";
        $jobtitle = "<H1 id='jobtitle'>".$name."</H1>";
        $metadata = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                     <div class="meta-icons"><i class="fa-solid fa-location-dot"></i><span class="meta-text">&nbsp;'.$office.'&nbsp;</span><i class="fa-solid fa-briefcase"></i><span class="meta-text">&nbsp;'.$jobET.'&nbsp;</span><i class="fa-regular fa-clock"></i><span class="meta-text">&nbsp;'.$jobSchedule.'&nbsp;</span></div>';


        $content .= '<style>

</style>

                        <div class="bildmitbildunterschrift">
                        <img src="' . $path . '" alt="Titelbild">
                        <span class="jobtitel">' . $jobtitle . '</span>
                        <span class="metadata">' . $metadata . '</span>
                        </div>
						 <form id="backform" action="'.$careerpage.'">
        <button id="backbutton" type="submit"><i class="fa-solid fa-angle-left"></i> Alle Stellen anzeigen</button>
            </form>
                        <div id="scrollup"></div>';

        $content.= "<div id='shownot' class='shownot'>";


        for($j = 0; $j < 5; $j++){
            $data1 = $positions->position->$i->jobDescriptions->jobDescription->$j->name;
            $data2 = $positions->position->$i->jobDescriptions->jobDescription->$j->value;

            $content .= "<div class='DescriptionName$j'>".strip_tags($data1)."</div>";
            $content .= "<div class='DescriptionValue$j'>".$data2."</div>";

        }

        $redirectID = getWordPressID($id);
        if($redirectID != null){
            $redirectURL = getPostURL($redirectID);
        }else{
            $redirectURL = home_url();
        }



        $content .= '<script>jQuery(document).ready(function(){
        jQuery("#Mybtn").click(function(){
            jQuery(".form").show(500);
             jQuery(".shownot").hide(500);
             jQuery("html, body").animate({
scrollTop: jQuery("#scrollup").offset().top
}, 1000);
        });
    });
</script>

<script>jQuery(document).ready(function(){
        jQuery("#Mybtn1").click(function(){
            jQuery(".form").hide(500);
             jQuery(".shownot").show(500);  
             jQuery("html, body").animate({
scrollTop: jQuery("#hide").offset().top
}, 1000);
        });
    });
</script>

<script type="text/javascript">
function redirect()
{
    window.location.href="'.$redirectURL.'";
}
</script>

<style>
.form{
	display: none;
}	
</style>

<button id="Mybtn">Jetzt bewerben!</button>
</div>
</div>
<div id="form" class="form">

<h3 id="formheadline">Wir haben Dir gerade noch gefehlt?</h3>
<p> Dann freuen wir uns über Deine Bewerbung - inklusive Eintrittstermin und Gehaltsvorstellung.</p>

<form id="personioApplicationForm" class="form-horizontal" method="POST" action="https://api.personio.de/recruiting/applicant" enctype="multipart/form-data">

        <input name="access_token" type="hidden" value="56eae2b614cc6d8d382a">

  <label for="vorname">NAME:<sup>*</sup></label><br>
      <input type="text" id="vorname" name="first_name" placeholder="Vorname" required><input type="text" id="nachname" name="last_name" placeholder="Nachname" required>
      
      <input name="company_id" type="hidden" value="43207">
        
  <label for="email">E-MAIL:<sup>*</sup></label><br>
        <input type="text" id="email" name="email" placeholder="yourmail@domain.com" required>
        
        <input name="job_position_id" type="hidden" value="'.$id.'">
        
  <label for="phone">TELEFON:<sup>*</sup></label><br>
        <input type="text" id="phone" name="phone" placeholder="+49 176 123 4455" required>
        
        <input id="rcid" name="recruiting_channel_id" type="hidden" value="">
        
  <label for="available_from">VERFÜGBAR AB</label><br>
        <input type="text" id="available_from" name="available_from" placeholder="" required> 
        
      <label for="documents">Lade dein Lebenslauf, Anschreiben, Arbeitszeugnisse oder andere Dokumente hoch. <sup>*</sup><br><span>Du kannst mehrere Dateien auf einmal auswählen.</span></label>
          <input id="documents" name="documents[]" type="file" style="margin-top: 10px;" multiple="" required="">
       
    ';

        if($employmentType == 'permanent' || $employmentType == 'temporary'){

        $content .= '
       <label for="salary_expectations">GEHALTSWUNSCH</label><br>
            <input type="text" id="salary_expectations" name="salary_expectations" placeholder="" required> 
            ';
        }
$content .= '
      <p><input type="checkbox" id="privacy-policy-acceptance" name="privacy-policy-acceptance" required>Hiermit bestätige ich, dass ich die <a href="https://skopos.jobs.personio.de/privacy-policy?language=de">Datenschutzerklärung</a> zur Kenntnis genommen habe.*</label></p>

<input id="submitButton" type="submit" value="Bewerbung abschicken" onclick="redirect();">

</form>

<button id="Mybtn1">Abbrechen</button>
</div>
';

        $content.="<script>
                    jQuery.urlParam = function(name){
                        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                        return results[1] || 0;
                        }
                        var string = jQuery.urlParam('channelID');
                        jQuery('#rcid').val(string);
                    </script>";

        $content .= '
<script type="application/ld+json"> 
{
  "@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "'.$name.'",
  "description": "'.$keywords.'", 
  "identifier": {
    "@type": "PropertyValue",
    "value": "'.$id.'"
  },
  "hiringOrganization" : {
    "@type": "Organization",
    "name": "'.$subcompany.'"
  },
  "employmentType": "'.$schedule.'",
  "datePosted": " '.$createdAt.'",
  "validThrough": "",
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "'.$jobPostalAddress.'",
      "addressLocality": "'.$office.'",
      "addressRegion":"'.$jobRegion.'",
      "postalCode": "'.$jobPostalCode.'",
      "addressCountry": "DE"
    }
  },
  "experienceRequirements": "'.$yearsOfExperience.'"
}
</script>
';
        $logcontent .= "---------".$i."--------- \n";
        $logcontent .= date("d/m/Y H:i:s")." - ".$id." - ".$name." goes into IF or ELSE section \n";
        if(in_array( $id,$arrayPersonioIDsinWordPress)){
            if(in_array($id, $arrayXMLPersonio)){
                $logcontent .= date("d/m/Y H:i:s")." - ".$id." - ".$name." was updated \n";
                $update_post = array(
                    'ID'           => getWordPressID($id),
                    'post_author'  => '442123924562346',
                    'post_title'   => $name,
                    'post_content' => $content,
                    'post_status' => 'publish',
                );
                kses_remove_filters(); //This Turns off kses
                wp_update_post( $update_post );
                kses_init_filters(); //This Turns on kses again
                updateP2W($id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule);
            }
        }else{
            $logcontent .= date("d/m/Y H:i:s")." - ".$id." - ".$name." was created \n";
            kses_remove_filters(); //This Turns off kses
            $post_id = postcreator($name,$content,'publish','442123924562346','page');
            kses_init_filters(); //This Turns on kses again
            //442123924562346 is the authors id to see in the database which page the plugin has generated
            insertP2W($id,$post_id);
            updateP2W($id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule);
        }
        $logcontent .="\n";
        $i++;
    }
    foreach ($arrayPersonioIDsinWordPress as $id){
        $wid = getWordPressID($id);
        $postname = getPostTitle($wid);
        if(!in_array($id,$arrayXMLPersonio)){
            $logcontent .= date("d/m/Y H:i:s")." - ".$id." - ".$postname." was deleted \n";
            wp_delete_post(getWordPressID($id));
            deleteP2W($id);
        }
    }

    //mail("bob.limbach@skopos.de","LOG-TEXT",$logcontent);
}
?>
