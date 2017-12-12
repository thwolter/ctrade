<?php


function set_active($path, $active = 'active')
{

    return Request::is($path) ? $active : '';
}

function active_tab($tab, $active = 'active')
{
    $a=1;
    return session('active_tab') === $tab ? $active : '';
}

/**
 * Set the session variable 'active_tab' to be evaluated in views to set the specified
 * tab as active. The session variable can be used for redirects and view calls.
 *
 * @param \Illuminate\Http\Request $request
 * @param $default
 */
function setActiveTab(Illuminate\Http\Request $request, $default)
{
    $tab = $request->get('active_tab', session('active_tab', $default));
    session(['active_tab' => $tab]);
}



/**
 * Return the array's value or 0 in case of null value.
 *
 * @param $value
 * @return int|mixed
 */
function array_first_or_null($value)
{
    return is_null($value) ? 0 : array_first($value);
}


function array_index($needle, $array)
{
    for ($i = 0; $i < count($array); $i++) {
        if (array_values($array)[$i] == $needle) return $i;
    }
}


function doneInfo($entities, $name)
{
    $count = count($entities);

    return sprintf("Done (%s %s). \n", $count, str_plural($name, $count));
}


function array_dissociate($array)
{
    $result = [];
    foreach($array as $key => $value) {
        $result[] = array_flatten(array_prepend($value, $key));
    }
    return $result;
}
