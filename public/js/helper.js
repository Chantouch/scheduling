/**
 * Created by Chantouch on 7/17/2017.
 */
function month($month) {
    $strout = '';
    $strchar = $month;
    if ($strchar === '01' || $strchar === '1') {
        $strout += 'មករា';
    }
    if ($strchar === '2' || $strchar === '02') {
        $strout += 'កុម្ភៈ';
    }
    if ($strchar === '3' || $strchar === '03') {
        $strout += 'មិនា';
    }
    if ($strchar === '4' || $strchar === '04') {
        $strout += 'មេសា';
    }
    if ($strchar === '5' || $strchar === '05') {
        $strout += 'ឧសភា';
    }
    if ($strchar === '6' || $strchar === '06') {
        $strout += 'មិថុនា';
    }
    if ($strchar === '7' || $strchar === '07') {
        $strout += 'កក្កដា';
    }
    if ($strchar === '8' || $strchar === '08') {
        $strout += 'សីហា';
    }
    if ($strchar === '9' || $strchar === '09') {
        $strout += 'កញ្ញា';
    }
    if ($strchar === '10') {
        $strout += 'តុលា';
    }
    if ($strchar === '11') {
        $strout += 'វិច្ឆិកា';
    }
    if ($strchar === '12') {
        $strout += 'ធ្នូ';
    }
    return $strout;
}
