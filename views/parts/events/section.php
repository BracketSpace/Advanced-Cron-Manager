<?php
/**
 * Events section part
 */
?>

<div id="events">

	<div class="tablenav top">

		<div class="alignleft actions">
			<select>
				<option value="-1">Bulk Actions</option>
				<option value="run">Execute now</option>
				<option value="pause">Pause</option>
				<option value="remove">Remove</option>
			</select>
			<input type="submit" class="button action" value="Apply">
		</div>

		<div class="alignleft actions">
			<select class="schedules-filter">
				<option value="">All Schedules</option>
				<option value="weekly">Once Weekly</option>
				<option value="hourly">Once Hourly</option>
				<option value="twicedaily">Twice Daily</option>
				<option value="daily">Once Daily</option>
			</select>
		</div>

		<div class="tablenav-pages one-page">
			<span class="displaying-num">4 events</span>
		</div>

	</div>

	<div class="events tile">

		<div class="single-event header">
			<div class="columns">
				<div class="column cb"><input type="checkbox" class="select-all"></div>
				<div class="column event"><?php _e( 'Event' ); ?></div>
				<div class="column schedule"><?php _e( 'Schedule' ); ?></div>
				<div class="column arguments"><?php _e( 'Arguments' ); ?></div>
				<div class="column next-execution"><?php _e( 'Next execution' ); ?></div>
			</div>
		</div>

		<?php foreach (array( 'wp_theme_check' => 'daily', 'wp_version_check' => 'hourly', 'wp_plugin_check' => 'daily', 'wp_trash_clean' => 'weekly' ) as $event => $schedule ): ?>

		<div class="single-event row" data-schedule="<?php echo $schedule; ?>">
			<div class="columns">
				<div class="column cb"><input type="checkbox" name=""></div>
				<div class="column event">
					<a href="#" class="event-name"><?php echo $event; ?></a>
					<div class="row-actions">
						<span class="details"><a href="#">Details</a> | </span>
						<span class="run"><a href="#">Execute now</a> | </span>
						<span class="pause"><a href="#">Pause</a> | </span>
						<span class="trash"><a href="#">Remove</a></span>
					</div>
				</div>
				<div class="column schedule"><?php echo $schedule; ?></div>
				<div class="column arguments"><span>arg1</span><span>arg2</span></div>
				<div class="column next-execution">In 4 hours<br>2017-06-10 12:34:56</div>
			</div>
			<div class="details">
				<ul class="tabs">
					<li class="active"><a href="#" data-section="logs">Logs</a></li>
					<li class="arguments"><a href="#" data-section="arguments">Arguments</a></li>
					<li><a href="#" data-section="implementation">Implementation</a></li>
				</ul>
				<div class="content logs active">
					Logs
				</div>
				<div class="content arguments">
					Arguments
				</div>
				<div class="content implementation">
					Implementation
				</div>
			</div>
		</div>

		<?php endforeach ?>

		<div class="single-event header">
			<div class="columns">
				<div class="column cb"><input type="checkbox" class="select-all"></div>
				<div class="column event"><?php _e( 'Event' ); ?></div>
				<div class="column schedule"><?php _e( 'Schedule' ); ?></div>
				<div class="column arguments"><?php _e( 'Arguments' ); ?></div>
				<div class="column next-execution"><?php _e( 'Next execution' ); ?></div>
			</div>
		</div>

	</div>

	<div class="tablenav bottom">

		<div class="alignleft actions">
			<select>
				<option value="-1">Bulk Actions</option>
				<option value="run">Execute now</option>
				<option value="pause">Pause</option>
				<option value="remove">Remove</option>
			</select>
			<input type="submit" class="button action" value="Apply">
		</div>

		<div class="alignleft actions">
			<select class="schedules-filter">
				<option value="">All Schedules</option>
				<option value="weekly">Once Weekly</option>
				<option value="hourly">Once Hourly</option>
				<option value="twicedaily">Twice Daily</option>
				<option value="daily">Once Daily</option>
			</select>
		</div>

		<div class="tablenav-pages one-page">
			<span class="displaying-num">4 events</span>
		</div>

	</div>

	<?php $this->get_view( 'elements/add-event-button' ); ?>

</div>
