<fieldset class="personalblock">
	<legend><?php p($l->t('Mozilla Sync')); ?></legend>
    <?php
    if (!\OCA\mozilla_sync\User::checkUserIsAllowed()) {
        $authorizedGroup = \OCA\mozilla_sync\User::getAuthorizedGroup();
        ?>
        <p><b><span style="color: red"><?php p($l->t('Error! You are not allowed to use Mozilla Sync! You need to be a member of the %s group.', $authorizedGroup));?></span></b></p><br />
    <?php
    }
    ?>
    <p><label>Client Configuration</label>
    <table class="nostyle">
      <tr>
        <td><?php p($l->t('Email'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><code><?php p($_['email']);?></code>&nbsp;&nbsp;&nbsp;<?php
            if (!OCA\mozilla_sync\User::userHasUniqueEmail()) {
                ?><b><span style="color: red"><?php p($l->t('Error! Duplicate email addresses detected! Email addresses need to be unique for Mozilla Sync to work.'));?></span></b><?php
            }?></td>
      </tr>
      <tr>
        <td><?php p($l->t('Password'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php p($l->t('Use your ownCloud account password'));?></td>
      </tr>
      <tr>
        <td><?php p($l->t('Server address'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><code><?php p($_['syncaddress']);?></code></td>
      </tr>
    </table>
    <i><?php
        $lastMod = \OCA\mozilla_sync\Storage::getLastModifiedTime();
        if ($lastMod === false) {
            p($l->t("To set up Mozilla Sync create a new Sync account in Firefox."));
        } else {
            p($l->t("Mozilla Sync is set up, additional devices can be added via Mozilla's device pairing service or manually."));
        }
        ?></i>
    </p>

    <br>

    <p><label>Sync Status</label>
    <table class="nostyle">
      <tr>
        <td><?php p($l->t('Last sync'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php
            if ($lastMod === false) {
                p($l->t('No successful sync yet.'));
            } else {
                p($lastMod);
            }
            ?></td>
      </tr>
      <tr>
        <td><?php p($l->t('Size of stored data'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php
            $size = \OCA\mozilla_sync\Storage::getSyncSize();
            if ($size === false) {
                p($l->t('No data stored yet.'));
            } else {
				$percentage = (float)$size/(float)\OCA\mozilla_sync\User::getQuota()*100.0;
                p($size . " KB (" . number_format($percentage,1) . "%)");
            }
            ?></td>
      </tr>
	  <tr>
		<td><?php p($l->t('Quota size'));?>&nbsp;&nbsp;&nbsp;</td>
		<td><?php
			$size = \OCA\mozilla_sync\User::getQuota();
			if ($size === 0) {
				p($l->t('unlimited'));
			} else {
				p($size . " KB");
			}
		?></td>
	  </tr>
      <tr>
        <td><?php p($l->t('Number of synced devices'));?>&nbsp;&nbsp;&nbsp;</td>
        <td><code><?php p(\OCA\mozilla_sync\Storage::getNumClients()); ?></code></td>
      </tr>
    </table>
    </p>
</fieldset>
