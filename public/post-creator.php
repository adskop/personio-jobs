<?php
function cron_job_task(){
    // Draw job postings from Personio API
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        // check for plugin using plugin name
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
    $arrayPostsID = getPostsIDs();
    $arrayP2W = getWordPressIDs();


    for ($i=0; $i < count($arrayP2W); $i++)
    {
        if (!in_array("$arrayP2W[$i]",$arrayPostsID,true))
        {
            echo $arrayP2W[$i].",";
        }
    }

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

        if($schedule == 'full-time'){
            $jobSchedule = 'Vollzeit';
        }elseif($schedule == 'part-time'){
            $jobSchedule = 'Teilzeit';
        }

        if($employmentType == 'permanent'){
            $jobET = 'Festanstellung';
        }elseif($employmentType == 'intern'){
            $jobET = 'Mitarbeitende im Praktikum / Studentenjob';
        }elseif($employmentType == 'working_student'){
            $jobET = 'Werkstudierende';
        }elseif($employmentType == 'trainee'){
            $jobET = 'Ausbildung/Trainee';
        }

        $path = "http://bob.sandbox.skoposweb.de/wp-content/plugins/personio-jobs/public/personio_job_pic1.png";
        $content.= "<div id='hide' class='hide'>";
        $jobtitle = "<H1 id='jobtitle'>".$name."</H1>";
        $metadata = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                     <div class="meta-icons"><i class="fa-solid fa-location-dot"></i><span class="meta-text">&nbsp;'.$office.'&nbsp;</span><i class="fa-solid fa-briefcase"></i><span class="meta-text">&nbsp;'.$jobET.'&nbsp;</span><i class="fa-regular fa-clock"></i><span class="meta-text">&nbsp;'.$jobSchedule.'&nbsp;</span></div>';

        $content .= '<div class="bildmitbildunterschrift">
                        <img src="' . $path . '" alt="Titelbild">
                        <span class="jobtitel">' . $jobtitle . '</span>
                        <span class="metadata">' . $metadata . '</span>
                        </div>';

        for($j = 0; $j < 5; $j++){
            $data1 = $positions->position->$i->jobDescriptions->jobDescription->$j->name;
            $data2 = $positions->position->$i->jobDescriptions->jobDescription->$j->value;

            $content .= "<div class='DescriptionName$j'>".strip_tags($data1)."</div>";
            $content .= "<div class='DescriptionValue$j'>".$data2."</div>";

        }


        $content .= '<script>jQuery(document).ready(function(){
        jQuery("#Mybtn").click(function(){
            jQuery("#personioApplicationForm").toggle(500);
             jQuery(".hide").hide(500);
        });
    });
</script>

<style>
#personioApplicationForm{
	display: none;
}	
</style>

<button id="Mybtn" class="btn btn-primary">Jetzt bewerben!</button>
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<form id="personioApplicationForm" class="form-horizontal" method="POST" action="https://api.personio.de/recruiting/applicant" enctype="multipart/form-data">

  <label for="name">NAME:</label><br>
      <input type="text" id="name" name="first_name" placeholder="Vorname" required><input type="text" id="name" name="last_name" placeholder="Nachname" required>
        
  <label for="email">EMAIL:</label><br>
        <input type="text" id="email" name="email" placeholder="yourmail@domain.com" required>
        
  <label for="phone">TELEFON:</label><br>
        <input type="text" id="phone" name="phone" placeholder="+49 176 123 4455" required>
        
  <label for="available_from">VERFÜGBAR AB</label><br>
        <input type="text" id="available_from" name="available_from" placeholder="" required> 
        
   
        
        <input type="checkbox" id="privacy-policy-acceptance" name="privacy-policy-acceptance" required>
<label for="privacy-policy-acceptance">Hiermit bestätige ich, dass ich die <a href="https://skopos.jobs.personio.de/privacy-policy?language=de">Datenschutzerklärung</a> zur Kenntnis genommen habe.*</label>

</form>';

        $content .= '
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "'.$name.'",
  "description": "'.$keywords.'", 
  "identifier": {
    "@type": "PropertyValue",
    "name": "'.$subcompany.'",
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
      "streetAddress": "Hans-Böckler-Str. 163",
      "addressLocality": "Hürth",
      "postalCode": "50354",
      "addressCountry": "DE"
    }
  },
  "responsibilities": "",
  "skills": "",
  "qualifications": "",
  "educationRequirements": "",
  "experienceRequirements": "'.$yearsOfExperience.'"
}
</script>
';




        if(in_array( $id,$arrayPersonioIDsinWordPress)){
            if(in_array($id, $arrayXMLPersonio)){
                //update
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
            }else{
                //löschen
                wp_delete_post(getWordPressID($id));
                deleteP2W($id,getWordPressID($id));
            }
        }else{
            //erstellen
            kses_remove_filters(); //This Turns off kses
            $post_id = postcreator($name,$content,'publish','442123924562346','page');
            kses_init_filters(); //This Turns on kses again
            //442123924562346 is the authors id to see in the database which page the plugin has generated
            insertP2W($id,$post_id);
            updateP2W($id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule);
        }

        $i++;
    }
}
?>
