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


        // $content .= "<div class='id'>".$id."</div>";
        // $content .= "<div class='subcompany'>".$subcompany."</div>";
        //$content .= "<div class='office'>".$office."</div>";
        //$content .= "<div class='department'>".$department."</div>";
        //$content .= "<div class='recruitingCategory'>".$recruitingCategory."</div>";
        $content .= "<div class='name'>".$name."</div>";


        for($j = 0; $j < 5; $j++){
            $data1 = $positions->position->$i->jobDescriptions->jobDescription->$j->name;
            $data2 = $positions->position->$i->jobDescriptions->jobDescription->$j->value;

            $content .= "<div class='DescriptionName$j'>".strip_tags($data1)."</div>";
            $content .= "<div class='DescriptionValue$j'>".strip_tags($data2)."</div>";

        }




        $content .= '
<script src="'.ABSPATH. 'wp-content/plugins/personio-jobs/public/form_toogle.js"></script>

<button id="Mybtn" class="btn btn-primary">Jetzt bewerben!</button>
<form id="personioApplicationForm" class="form-horizontal" method="POST" action="https://api.personio.de/recruiting/applicant" enctype="multipart/form-data">
    <fieldset>
             <article class="detail-content-block detail-apply-form-description">
        <h5 class="detail-block-title">Wir haben Dir gerade noch gefehlt? </h5>
        <div class="detail-block-description">
            Dann freuen wir uns über Deine Bewerbung - &nbsp;inklusive Gehaltsvorstellung und Eintrittstermin.<br><br>
        </div>
    </article>
        <!-- Pass authentication token -->
        <input name="access_token" type="hidden" value="a8056a2f81a8acd27a68">

        <!-- Pass company and position_id -->
        <input name="company_id" type="hidden" value="000">
        <input name="job_position_id" type="hidden" value="000">

        <!-- You can pass all applicant system attributes -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="first_name">Name <sup>*</sup></label>
            <div class="col-md-4">
                <input id="first_name" name="first_name" type="text" placeholder="Vorname" class="form-control input-md" required="">
                <input id="last_name" name="last_name" type="text" placeholder="Nachname" class="form-control input-md" style="margin-top: .5em" required="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="email">E-Mail <sup>*</sup></label>
            <div class="col-md-4">
                <input id="email" name="email" type="text" placeholder="yourmail@domain.com" class="form-control input-md" required="">
            </div>
        </div>
         <div class="form-group">
            <label class="col-md-4 control-label" for="phone">Telefon</label>
            <div class="col-md-4">
                <input id="phone" name="phone" type="text" placeholder="+49 176 123 4455" class="form-control input-md" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="available_from">Verfügbar ab</label>
            <div class="col-md-4">
                <input id="available_from" name="available_from" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>
        <!-- Multiple documents up to 50MB can be passed -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="documents">Bitte lade Deinen Lebenslauf, aktuelle Zeugnisse und ein kurzes Anschreiben hoch (insgesamt max. 50 MB). <sup>*</sup><br><span style="font-size: 0.8em">Du kannst mehrere Dokumente auf einmal auswählen</span></label>
            <div class="col-md-4">
                <input id="documents" name="documents[]" class="input-file" type="file" style="margin-top: 10px;" multiple="" required="">
            </div>
        </div>
        <div class="form-group">
        <input class="form-check-input" required="" type="checkbox" id="privacy-policy-acceptance" name="privacy-policy-acceptance">
        <label class="form-check-label privacy-policy-statement-link" for="privacy-policy-acceptance">
                    Hiermit bestätige ich, dass ich die <a href="https://skopos.jobs.personio.de/privacy-policy?language=de" target="_blank">Datenschutzerklärung</a> zur Kenntnis genommen habe.<span>*</span>
                </label>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="message">Ist alles ausgefüllt?</label>
            <div class="col-md-4">
                <input id="submitButton" type="submit" value="Bewerbung abschicken">
            </div>
        </div>

    </fieldset>
</form>';




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

                wp_update_post( $update_post );
                updateP2W($id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule);
            }else{
                //löschen
                wp_delete_post(getWordPressID($id));
                deleteP2W($id,getWordPressID($id));
            }
        }else{
            //erstellen
            $post_id = postcreator($name,$content,'publish','442123924562346','page');
            //442123924562346 is the authors id to see in the database which page the plugin has generated
            insertP2W($id,$post_id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule);
        }

        $i++;
    }
}
?>
