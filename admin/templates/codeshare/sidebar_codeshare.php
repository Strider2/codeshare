<h3>Codeshare</h3>
<br />
<center>
<?php
if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS))
{
?>
<a href="<?php echo SITE_URL?>/admin/index.php/CodeShare_admin">Codeshare Main</a><br />
<a href="<?php echo SITE_URL?>/admin/index.php/CodeShare_admin/new_codeshare">Create New Codeshare</a><br />
<a href="<?php echo SITE_URL?>/admin/index.php/CodeShare_admin/airline">Codeshar Airlines</a><br />
<a href="<?php echo SITE_URL?>/admin/index.php/Codeshare_admin/new_codeshare_airline">Add Airline</a><br />
<?php
}
?>
</center>
<br />
