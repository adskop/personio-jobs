<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       hkvlaanderen.nl
 * @since      1.0.0
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/admin
 * @author     Hendrik Vlaanderen <h.k.vlaanderen@gmail.com>
 */
class Personio_Jobs_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Personio_Jobs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Personio_Jobs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/personio-jobs-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Personio_Jobs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Personio_Jobs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/personio-jobs-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_page() {
        $page_title = 'Personio';
        $menu_title = 'Personio';
        $capability = 'manage_options';
        $menu_slug = 'personio-jobs';
        $function = 'display_settings';
        $icon_url = '';
        $position = 24;

        $function = array($this, 'plugin_settings_page_content');

        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }

		public function plugin_settings_page_content() { ?>
    <div class="wrap">

        <h2>Personio Job Settings</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'smashing_fields' );
                do_settings_sections( 'smashing_fields' );
                submit_button();
            ?>
        </form>
    </div> <?php
		}


		public function setup_sections() {

        add_settings_section( 'our_first_section', ' Personio-Subdomain', array( $this, 'section_callback' ), 'smashing_fields' );
        add_settings_section( 'our_second_section', 'cron-Job', array( $this, 'section_callback' ), 'smashing_fields' );

		}

		public function section_callback( $arguments ) {
			switch( $arguments['id'] ){
	        case 'our_first_section':
	            break;
	        case 'our_second_section':
	            echo 'Ein CronJob ist eine Aufgabe, die in Betriebssystemen automatisiert abläuft.';
	            break;
	    }
	}

	public function setup_fields() {
    $fields = array(
        array(
            'uid' => 'personio-host',
            'label' => 'Host Name',
            'section' => 'our_first_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => '',
            'helper' => 'Sie finden den Host Name in der URL Ihres Personio-Unternehmensprofils',
            'supplemental' => 'in Kleinbuchstaben',
            'default' => ''
        ),
				array(
            'uid' => 'personio-company',
            'label' => 'Name des Unternehmens',
            'section' => 'our_first_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => '',
            'helper' => 'Ein Host kann auch mehrere Unternehmen haben. Verwenden Sie diese Option, wenn Sie nur die Stellenanzeigen eines bestimmten Teilunternehmens oder einer Tochtergesellschaft anzeigen möchten',
            'supplemental' => 'in Kleinbuchstaben',
            'default' => ''
        ),
        array(
            'uid' => 'personio-filter',
            'label' => 'Filter für Jobs',
            'section' => 'our_first_section',
            'type' => 'checkbox',
            'options' => false,
            'placeholder' => '',
            'helper' => 'Bei Aktivierung wird nicht nach Art der Anstellung (Festanstellung etc.) gefiltert sondern nach Units',
            'supplemental' => '',
            'default' => ''
        ),

        array(
            'uid' => 'personio-cron-on-off',
            'label' => 'An-/Aus- schalten',
            'section' => 'our_second_section',
            'type' => 'checkbox',
            'options' => false,
            'placeholder' => '',
            'helper' => 'CronJob ein oder ausschalten (ist das Häkchen gesetzt ist der CronJob aktiviert)',
            'supplemental' => '',
            'default' => ''
        ),
                array(
            'uid' => 'personio-cron-intervall',
            'label' => 'Intervall',
            'section' => 'our_second_section',
            'type' => 'select',
            'options' => false,
            'placeholder' => '',
            'helper' => 'Auswahl wie oft der CronJob die Stellenanzeige generien/updaten/löschen soll. (Standardmäßig ist "Jede Stunde" eingestellt)',
            'supplemental' => '',
            'default' => ''
        ),
        array(
            'uid' => 'personio-cron-email-on-off',
            'label' => 'An-/Aus- schalten für eine Bestätigungsmail',
            'section' => 'our_second_section',
            'type' => 'checkbox',
            'options' => false,
            'placeholder' => '',
            'helper' => 'Bestätigungsmail ein oder ausschalten (ist das Häkchen gesetzt ist die Bestätigungsmail aktiviert)',
            'supplemental' => '',
            'default' => ''
        ),
        array(
            'uid' => 'personio-cron-email',
            'label' => 'E-Mail Adresse',
            'section' => 'our_second_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => 'name@mail.com',
            'helper' => 'E-Mail Adresse für die Bestätigungsmail',
            'supplemental' => '',
            'default' => ''
        ),
        array(
            'uid' => 'personio-career-page',
            'label' => 'Karriere Seite',
            'section' => 'our_second_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => 'www.domain.com/career',
            'helper' => 'Verlinkung der Karriere Seite für den Zurück-Knopf',
            'supplemental' => '',
            'default' => ''
        ),
    );

    foreach( $fields as $field ){
        add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'smashing_fields', $field['section'], $field );
        register_setting( 'smashing_fields', $field['uid'] );
    	};
	}
public function field_callback( $arguments ) {
    require_once( ABSPATH . 'wp-content/plugins/personio-jobs/public/post-creator1.php' );
    $cronIntervall = getCronIntervall();
    $cronIntervallName = "";

    if($cronIntervall === 0){
        $cronIntervallName = "Bitte auswählen";
    }elseif($cronIntervall == "everyminute"){
        $cronIntervallName = "Jede Minute";
    }elseif($cronIntervall == "everyhalfhour"){
        $cronIntervallName = "Jede halbe Stunde";
    } elseif($cronIntervall == "everyhour"){
        $cronIntervallName = "Jede Stunde";
    }elseif($cronIntervall == "twiceday"){
        $cronIntervallName = "Zweimal Täglich";
    }elseif($cronIntervall == "onceday"){
        $cronIntervallName = "Einmal Täglich";
    }

    $value = get_option( $arguments['uid'] ); // Get the current value, if there is one
		if( ! $value ) { // If no value exists
				$value = $arguments['default']; // Set to our default
		}

		// Check which type of field we want
		switch( $arguments['type'] ){
				case 'text': // If it is a text field
						printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
						break;
			 case 'checkbox':
			 if($value) :

				 printf( '<input name="%1$s" id="%1$s" type="%2$s" value="%3$s" checked="checked" />', $arguments['uid'], $arguments['type'], $value );
			 else:
				 printf( '<input name="%1$s" id="%1$s" type="%2$s" value="%3$s" />', $arguments['uid'], $arguments['type'], true );
			 endif;
			 break;
            case 'select':
                printF('
                <select name="%1$s" id="%1$s">
                 <option value="'.$cronIntervall.'" disabled selected hidden>'.$cronIntervallName.'</option>
                  <option value="everyminute">Jede Minute</option>
                  <option value="everyhalfhour">Jede halbe Stunde</option>
                  <option value="everyhour">Jede Stunde</option>
                  <option value="twiceday">Zweimal Täglich</option>
                  <option value="onceday">Einmal Täglich</option>
                </select>
                ', $arguments['uid']);
                break;
		}

		// If there is help text
		if( $helper = $arguments['helper'] ){
				printf( '<span class="helper"> %s</span>', $helper ); // Show it
		}

		// If there is supplemental text
		if( $supplimental = $arguments['supplemental'] ){
				printf( '<p class="description">%s</p>', $supplimental ); // Show it
		}
}

}
