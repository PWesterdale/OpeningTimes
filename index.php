<?

spl_autoload_register(function ($class) {
    include 'src/' . str_replace('\\', '/', $class) . '.php';
});


$core_times = [
	1 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (21 * 60 * 60)]
	],
	2 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (21 * 60 * 60)]
	],
	3 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (21 * 60 * 60)]
	],
	4 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (21 * 60 * 60)]
	],
	5 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (21 * 60 * 60)]
	],
	6 => [
		'breakfast' => ['start' => (9 * 60 * 60), 'end' => (11 * 60 * 60)],
		'lunch' => ['start' => (12.5 * 60 * 60), 'end' => (14 * 60 * 60)],
		'evening' => ['start' => (18 * 60 * 60), 'end' => (22 * 60 * 60)]
	],
	7 => [
		'breakfast' => false,
		'lunch' => false,
		'evening' => ['start' => (18 * 60 * 60), 'end' => (22 * 60 * 60)]
	],
];

$overrides = [
	[
		'name' => 'Closed Tuesday 24th March',
		'type' => 'on',
		'date' => '03-24-2015',
		'data' => ['breakfast' => false, 'lunch' => false, 'evening' => false]
	],
	[
		'name' => 'Closed Every Wednesday for March',
		'type' => 'period_on',
		'on' => [3],
		'date_from' => '03-01-2015',
		'date_to' => '03-29-2015',
		'data' => ['breakfast' => false, 'lunch' => false, 'evening' => false]
	],
	[
		'name' => 'Closed Over Christmas',
		'type' => 'period',
		'date_from' => '12-23-2015',
		'date_to' => '12-27-2015',
		'data' => ['breakfast' => false, 'lunch' => false, 'evening' => false]
	]
];

$calendar = new \OpeningTimes\Calendar($core_times, $overrides, (20 * 60), (60 * 60));

$c = $calendar->from(strtotime('Today'))->to(strtotime('Next Week'))->build()->getDailyTimes();

echo '<table>
<thead>
	<tr>
		<th>Date</th>
		<th>Breakfast</th>
		<th>Lunch</th>
		<th>Dinner</th>
	</tr>
</thead>
<tbody>';

foreach($c as $date){
	echo '<tr>
		<td>' . $date['date']->format('l jS F') . '</td>';

	foreach($date['times'] as $sitting => $time){
		if(!$date['times'][$sitting]['from']){
			echo '<td>Closed</td>';
		} else {
			echo '<td>' . $date['times'][$sitting]['from']->format('h:ia') . ' - ' . $date['times'][$sitting]['to']->format('h:ia') . '</td>';
		}
	}

	echo '</tr>';
}

echo '</tbody></table>';
