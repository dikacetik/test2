<script>
$(function() {
	var user_id;
	$('.statusclass').change(function () {
		var id = $(this).attr('data-status');
		var status = $(this).val();
		//console.log(th);
		$.ajax({
			type: "POST",
			url: "/leader/leader_damage_report/ajax",
			data: {id:id,status:status,action:'status'},
			success: function(msg){
			},
			error: function(){
			alert("failure");
			}
		});
	});

	$('.popup').click(function(){
	$('#threadModal').modal('show')
		user_id = $(this).attr('data-id');
		$('#user_id').val(user_id);
		//console.log(th);
	})
	$("button#submit").click(function(){
		$.ajax({
			type: "POST",
			url: "/leader/leader_damage_report/ajax",
			data: $('form.contact').serialize(),
			success: function(msg){
				if($('.input-block-level-txt').val() != ""){
					$('#fixedReport'+user_id).html('Ja');
					$('#fixedReport'+user_id).attr({'class':'label label-success','title':$('.input-block-level-txt').val()});
				}else{
					$('#fixedReport'+user_id).append('Nej');
				}
				$("#threadModal").modal('hide');
				$('.input-block-level-txt').val('');
			},
			error: function(){
			alert("failure");
			}
		});
	});
});
</script>
<div class="row">
	<center>
		<h1>Skades Anmeldelser</h1>
	</center>

	<div class="col-md-10 col-md-offset-1">
		<table class="table table-striped table-bordered">
			<tr>
				<th>
					Navn
				</th>
				<th>
					Anmelders navn
				</th>
				<th>
					Svaret tilbage
				</th>
				<th>
					Status
				</th>
				<th style="width: 150px">
					Dato
				</th>
				<th style="width: 177px">
					Handlinger
				</th>
			</tr>

			<?php
			foreach($damage_reports as $damage_report){
				?>
					<tr>
						<th>
							<?php
								if(!empty($damage_report['Unit']['id'])){
									print $damage_report['Unit']['name'];
								} else if(!empty($damage_report['Item']['id'])){
									print $damage_report['Item']['name'];
								} else if(!empty($damage_report['DamageReport']['subject'])){
									print $damage_report['DamageReport']['subject'];
								}
							?>
						</th>
						<th>
							<a href="<?= $this->Html->url(array('controller' => 'leader_users', 'action' => 'view', $damage_report['User']['id'])) ?>">
								<?= $damage_report['User']['firstname'] ?> 
								<?= $damage_report['User']['lastname'] ?>
							</a>
						</th>
						<th style="text-align: center">
							<?php
							
							if($damage_report['DamageReport']['fixed']){
								?>
									<div id = "fixedReport<?php echo $damage_report['DamageReport']['id']; ?>" class="label label-success" title="<?php echo$damage_report['DamageReport']['message']; ?>">Ja</div>
								<?php
							} else {
								?>
									<div id = "fixedReport<?php echo $damage_report['DamageReport']['id']; ?>" class="label label-danger">Nej</div>
								<?php
							}
							?>
						</th>
						<th>
							<div class="crew_control_field_padding">
								<select id ="statusdat" class="statusclass" name="status" data-status="<?php echo $damage_report['DamageReport']['id']; ?>" >
								<option value="" >Vaelg status</option>
							
								<?php foreach($status as $statusoption){ 
									$selected = ''; if($statusoption  == $damage_report['DamageReport']['status']){ $selected = 'selected="selected"'; } ?>
									<option <?php echo $selected;?> value="<?php echo $statusoption; ?>" ><?php echo $statusoption; ?></option>
								<?php  } ?>
								</select>
							</div>
						</th>
						<th>
							<?php
								print date('d-m-Y H:i', $damage_report['DamageReport']['created']);
							?>
						</th>
						<th>
							<?= $this->Html->link('Vis', array('action' => 'single_report', $damage_report['DamageReport']['id']), array('class' => 'btn btn-success')) ?>
							
							<a data-toggle="modal" data-id="<?php echo $damage_report['DamageReport']['id']; ?>" href="#" class="btn btn-warning popup">Svar</a>
							
							<?= $this->Html->link('Slet', array('action' => 'delete', $damage_report['DamageReport']['id']), array('class' => 'btn btn-danger')) ?>
						</th>
					</tr>
				<?php
			}
			?>
		</table>
	</div>
</div>





<!-- Modal -->
<div class="modal fade" id="threadModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Svar</h4>
			</div>
			
			<div class="modal-body">
				<form class="contact">
					<fieldset>
						<div class="form-group">
							<div class="controls">
								<div class="input-group date col-md-12">
									<textarea class="form-control input-block-level-txt" style="height: 200px" name="message"></textarea>
									<input id="user_id" type="hidden" name = "id" value="id_damage" >
									<input id="ac" type="hidden" name = "action" value="popup" >
								</div>	
							</div>
						</div>
					</fieldset>
				</form>
			</div>
	  
	  		<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Luk</button>
				<button type="button" class="btn btn-primary" id="submit" >Send</button>
			</div>
		</div>
	</div>
</div>