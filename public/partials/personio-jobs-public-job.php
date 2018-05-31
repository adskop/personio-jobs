<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       hkvlaanderen.nl
 * @since      1.0.0
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/public/partials
 */
?>

<a class="job-button" target="_blank" href="<?= $j['position']['detailLink'] ?>">
  <span><?= $j['position']['name'] ?></span>
</a>
