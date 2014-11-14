<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<center>
			<h1>
				Skades Anmeldelse på <?php
								if(!empty($damage_report['Unit']['id'])){
									print $damage_report['Unit']['name'];
								} else if(!empty($damage_report['Item']['id'])){
									print $damage_report['Item']['name'];
								} else if(!empty($damage_report['DamageReport']['subject'])){
									print $damage_report['DamageReport']['subject'];
								}
							?>
			</h1>

			<b>Rapporteret af:</b>
			<a href="<?= $this->Html->url(array('controller' => 'leader_users', 'action' => 'view', $damage_report['User']['id'])) ?>">
				<?= $damage_report['User']['firstname'] ?> 
				<?= $damage_report['User']['lastname'] ?>
				( <?= $damage_report['User']['servant_id'] ?> )
			</a><br>

			<b>Rapporteret:</b> <?= date('d-m-Y H:i', $damage_report['DamageReport']['created']); ?>

			<?php
			if(!empty($damage_report['Unit']['id'])){
				?><br>
				<b>Påvirker kørsel:</b>
				<?php
				if($damage_report['DamageReport']['affects_driving']){
					print "<div class='label label-danger'>Ja</div>";
				} else {
					print "<div class='label label-success'>Nej</div>";
				}
			}
			?>
		</center>
	</div>
</div>

<div class="row">
	<br><br>
	<div class="col-md-4 col-md-offset-1">
		<b>Billede af skaden:</b><br>
		<?php
			if(!empty($damage_report['DamageReport']['file_id'])){
				?>
				<?php
				print $this->Html->image("/files/uploads/damage_reports/".$damage_report['DamageReport']['file_id'].".jpg", array('style' => 'width: 453px;
	height: 374px;'));
			} else {
				print "Intet billede vedlagt.";
			}
		?>
	</div>

	<div class="col-md-4 col-md-offset-1">
		<b>Beskrivelse af skaden:</b><br>
		<?= $damage_report['DamageReport']['description'] ?>
	</div>
</div>