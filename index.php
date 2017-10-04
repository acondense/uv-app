<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UV App</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome-min.css">
    <script src="js/vue.js"></script>
    <script src="js/axios.min.js"></script>
    <script src="js/moment.js"></script>
</head>
<body class="container">
    <div id="index_app">

        <nav class="navbar navbar-expand-sm navbar-light bg-faded">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">UV</a>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="nav-content">   
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="reservations.html">My Reservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <br /><br /><br /><br />
        <div class="row">
            <section class="col-md-6">
                <br />
                <h3>Search for Rides</h3>
                <div class="input-group">
                  <input type="text" class="form-control-lg form-control" placeholder="Ex. Manila">
                  <span class="input-group-btn">
                    <button class="btn btn-primary btn-lg" type="button">Go!</button>
                  </span>
                </div>
                    <br />
            </section>
            <section class="col-md-6 text-center">
                <br />
                    <h3>or...</h3>
                    <a href="#vans_section" class="btn btn-lg btn-info">Rent a Van</a>
                <br />
            </section>
        </div>
        <br /><br /><br /><br />

        
        <section>
            <div class="ride-list row">
                <div class="col-md-12">
                    <h2>Rides</h2>
                    <br>
                </div>
                <a :href="'ride.html?id=' + ride.id" v-for="ride in rides" class="col-md-3 ride-item">
                    <img :src="'images/locations/' + ride.end_image" style="object-fit: cover; height: 300px; width: 100%;">
                    <h4>{{ ride.start_name }} to {{ ride.end_name }}</h4>
                    <p>
                        <small>
                        Leaves at {{ ride.time | moment_time }}
                        <br />
                        {{ ride.date | moment_date }}
                        </small>
                    </p>
                </a>
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary" v-on:click="loadRides()">See more rides</button>
                </div>
                <br /><br /><br />
            </div>
        </section>
    </div>


    <footer>
        <hr />
        <p><small>(c) 2017</small></p>
    </footer>
</body>
<script>
    var app = new Vue({
        el: "#index_app",
        data: {
            rides: [],
            page: 1
        },
        methods: {
            loadRides: function() {
                axios.get('./api/rides?page=' + this.page)
                    .then(response => {
                        this.rides.push.apply(this.rides, response.data.rides);
                        this.page++;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        mounted() {
            this.loadRides();
        },
        filters: {
            moment_date: function(date) {
                return moment(date).format('MMMM Do');
            },
            moment_time: function(time) {
                return time
            }
        }
    })
</script>
</html>