<div class="calendar-container">
    <h1 class="month-year-caption"><?php echo date('F', $timeForFirstDayOfMonth); ?> <?php echo $year; ?></h1>
    <ul class="weekdays">
<?php
    // Loop for seven times to output weekday names
    for ($counter = 0, $i = $firstDayOfWeek; 7 > $counter; $counter++, $i++)
    {
?>
        <li><?php echo $weekdays[$i]; ?></li>
<?php
        // If counter reached to 6, set it to -1
        if (6 == $i)
        {
            $i = -1;
        }
    }
?>
    </ul><br class="clear" />
    <ul class="calendar">
<?php
    // Total number of days in current month/year
    $totalDaysInMonth = date('t', $timeForFirstDayOfMonth);

    // Weekday for first day of current month/year
    $weekdayForFirstDayOfMonth = date('w', $timeForFirstDayOfMonth);

    // If 'first day of week' is not equal to weekday for first day of month then proceed further to output empty TDs
    if ($firstDayOfWeek != $weekdayForFirstDayOfMonth)
    {
        // Calculate total empty days
        $totalEmptyDays = ($weekdayForFirstDayOfMonth - $firstDayOfWeek);

        // If first day of week is greater than weekday for first day of month then add 7 days to total empty days
        if ($firstDayOfWeek > $weekdayForFirstDayOfMonth)
        {
            $totalEmptyDays += 7;
        }

        // Loop for 'total empty days' to output empty LIs if first day of current month/year doesn't start on 'first day of week'
        for ($i = 0; $i < $totalEmptyDays; $i++)
        {
?>
        <li class="empty">&nbsp;</li>
<?php
        }
    }

    // Loop for total number of days in current month/year to output calendar with posts
    for ($day = 1; $day <= $totalDaysInMonth; $day++)
    {
        // If new week started then close current UL and start new one
        if (1 < $day && $firstDayOfWeek == date('w', mktime(0, 0, 0, $month, $day, $year)))
        {
?>
    </ul><br class="clear" />
    <ul class="calendar">
<?php
        }

        // Initialize variable used to store background image
        $backgroundImage = false;

        // If background image set for current day in current month/year then use it
        if (isset($backgroundImages[$month][$day]) && false !== $backgroundImages[$month][$day])
        {
            $backgroundImage = $backgroundImages[$month][$day];
        }
?>
        <li class="day"<?php echo ($backgroundImage ? ' style="background-image: url(' . $this->getImageUrl($backgroundImage, $boxDimension) . ');"' : ''); ?>>
<?php
        // If background image set for current day in current month/year then display that day in black/white
        if ($backgroundImage)
        {
?>
            <div class="blackDay"><?php echo $day; ?></div>
            <div class="whiteDay"><?php echo $day; ?></div><br class="clear" />
<?php
        }
        // If background image is not set for current day in current month/year then display that day simply
        else
        {
            echo $day;
        }

        // If any post(s) for current day in current month/year then display it/them
        if (isset($postsPerDay[$month][$day]))
        {
?>
            <ul<?php echo ($backgroundImage ? ' class="invisible"' : ''); ?>>
<?php
            // Loop through post(s) for current day in current month/year to display it/them
            foreach ($postsPerDay[$month][$day] as $key => $index)
            {
?>
                <li><a href="<?php echo get_permalink($posts[$index]->ID); ?>"><?php echo $posts[$index]->post_title; ?></a></li>
<?php
            }
?>
            </ul>
<?php
        }
?>
        </li>
<?php
    }

    // Weekday for last day of current month/year
    $weekdayForLastDayOfMonth = date('w', mktime(0, 0, 0, $month, $totalDaysInMonth, $year));

    // Calculate total empty days
    $totalEmptyDays = ($firstDayOfWeek - $weekdayForLastDayOfMonth - 1);

    // If first day of week is less than or equals to weekday for last day of month then add 7 days to total empty days
    if ($firstDayOfWeek <= $weekdayForLastDayOfMonth)
    {
        $totalEmptyDays += 7;
    }

    // Loop for 'total empty days' to output empty TDs if last day of current month/year doesn't end on 'first day of week'
    for ($i = 0; $i < $totalEmptyDays; $i++)
    {
?>
        <li class="empty">&nbsp;</li>
<?php
    }
?>
    </ul><br class="clear" /><br class="clear" />
</div>