<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->params['googleMapsKey'];
?>&libraries=places&callback=initMap1&language=ru&region=UA" defer></script>
<script>
    /*************************Autocomplite*****************************/
    let map;

    function initMap1() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 49.988358, lng: 36.232845},
            zoom: 12
        });
    }

    $(function () {
        function changeStreetOnClick()
        {
            $('#autocomplete').click(function() {
                var streetName = $(this).val();
                if(streetName === '') {
                    $(this).val('Харьков, ');
                }
            });
        }

        changeStreetOnClick();

        /*************************
         initAutocomplete
         *************************/
        function initAutocomplete() {
            if ($("#autocomplete").length) {
                var autocomplete;

                var cityBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng(49.990513, 36.230206));
                autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('autocomplete')),
                    {
                        bounds: cityBounds,
                        types: ['address'],
                        componentRestrictions: {country: 'ua'}
                    });

                autocomplete.addListener('place_changed', function () {

                    var placeFull = $('#autocomplete').val();

                    var place = autocomplete.getPlace().name;

                    var endOfStreet = place.indexOf(',');
                    var streetName = placeFull.substring(0, endOfStreet > 0 ? endOfStreet - 1 : place.length);

                    $('#autocomplete').val(place);

                    if(endOfStreet > 0) {
                        var buldingPositionEnd = place.indexOf(',', endOfStreet + 1);
                        var streetName = placeFull.substring(endOfStreet + 1, buldingPositionEnd > 0 ? buldingPositionEnd + 1 : place.length);
                        $('#apartment-number_building, #rent-number_building, #building-number_building, #house-number_building, #area-number_building, #commercial-number_office').val(streetName.trim().replace(',', ''));
                    }


                });
                $("#autocomplete").change(function(){
                    $(this).val('')
                })
            }
        }

        $('form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        //$('input[name="ApartmentSearch[street]"').attr('id', 'autocomplete');

        initAutocomplete();
    });
</script>
