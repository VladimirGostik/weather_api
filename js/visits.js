let button = document.querySelector('.countryButton')
$(document).ready(function () {
    $('.countryButton').click(function () {
        let countryName = $(this).text()
        fetch("api.php?country=" + countryName, {
            method: "GET"
        })
            .then(response => response.json())
            .then(result => {
                console.log(result)
                var layer = document.getElementById("newLayer")
                document.getElementById("newLayer").style.display = 'block';

                var close = document.createElement("div");
                close.className = "close";
                layer.appendChild(close);
                makeTable(layer, result);

                close.addEventListener("click", function () {
                    layer.style.display = 'none';
                    layer.innerHTML = '';
                });
            }
            );
    })
})

function makeTable(layer, result) {
    var table = document.createElement("table");
    var tableBody = document.createElement("tbody");
    table.className = "table1";
    tableBody.className = "tablebody";
    var tableHead = document.createElement("thead");
    var th1 = document.createElement("th");
    var th2 = document.createElement("th");
    th1.innerHTML = 'City'
    th2.innerHTML = 'Number of visits'

    tableHead.append(th1)
    tableHead.append(th2)
    tableHead.className = 'thead'

    result.forEach(element => {
        var row = document.createElement("tr")
        //console.log(element)
        var cell1 = document.createElement("td");
        var cell2 = document.createElement("td");

        cell1.innerHTML = element['City']

        fetch("api.php?count=" + element['City'], {
            method: "GET"
        })
            .then(response => response.json())
            .then(result => {
                console.log(result)
                cell2.innerHTML = result[0]['count(*)']
            })

        // cell2.innerHTML = count

        row.appendChild(cell1)
        row.appendChild(cell2)
        tableBody.appendChild(row)
    });

    table.appendChild(tableHead)
    table.appendChild(tableBody);
    layer.appendChild(table);
}

let map;

function initMap() {
    var maps = document.getElementById('googleMap');
    maps.innerHTML = '';
    map = new google.maps.Map(document.getElementById('googleMap'), {
        center: { lat: 48, lng: 0 },
        zoom: 2
    });
    fetch("api.php", {
        method: "GET"
    }).then(response => response.json()).then(result => {
        result.forEach(result => {
            console.log(result)
            var lat = result['Locality'].split(', ')[0].replace('(', '')
            var long = result['Locality'].split(', ')[1].replace(')', '')

            let markerOptions = {
                position: new google.maps.LatLng(lat, long),
                map: map
            }
            new google.maps.Marker(markerOptions);
        })
    })
}
