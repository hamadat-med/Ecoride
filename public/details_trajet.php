<div id="map" style="height: 400px;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=VOTRE_API_KEY&callback=initMap" async defer></script>
<script>
    function initMap() {
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: 48.8566, lng: 2.3522 }, // Paris par défaut
        });
        directionsRenderer.setMap(map);

        const request = {
            origin: "<?= $trajet['depart'] ?>",
            destination: "<?= $trajet['destination'] ?>",
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
            }
        });
    }
</script>
