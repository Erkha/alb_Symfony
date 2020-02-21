import '../css/adminapp.scss';

const $ = require('jquery');
require('jquery.easing');

require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
