<h1>{pagetitle}</h1>

<?php if (isset($periods)) { ?>
  <div class="row">
    <div class="col-xs-12">
        <h3 class="text-success">{bingo}</h3>
    </div>
  </div>

  <div class="row">
      <div class="col-md-4">
        {periods}
        <dl class="dl-horizontal">
          <dt>Day</dt><dd>{day}</dd>
          <dt>Time</dt><dd>{time}</dd>
          <dt>Course</dt><dd>{coursename}</dd>
          <dt>Teacher</dt><dd>{teacher}</dd>
          <dt>Location</dt><dd>{location}</dd>
          <dt>Type</dt><dd>{classtype}</dd>
        </dl>
        {/periods}
      </div>
  </div>
<?php } else { ?>
  <div class="row">
    <div class="col-xs-12">
        <p>Error: There were duplicate entries found</p>
    </div>
  </div>
<?php } ?>
