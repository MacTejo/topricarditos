<?php header('Access-Control-Allow-Origin: *'); ?>

<!-- Clean Cache -->
<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<?php
$token = "YOUR_TOKEN_HERE";
$opts = [
    "http" => [
        "header" => "auth:" . $token
    ]
];

$context = stream_context_create($opts);

// Add your clan URL
$test = file_get_contents("http://api.cr-api.com/clan/22CRJCRC", true, $context);

$test = preg_replace('/\\\\\"/', "\"", $test);

$test = str_replace("'", "", $test);

// All data save on top-ricarditos.json
$json_data = urldecode(stripslashes($test));
file_put_contents('clan.json', $json_data);

?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=no"/>
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Top Ricarditos</title>
   <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <div id="main">
      <div class="container">
         <div class="row d-flex align-items-center">
            <div class="col-md-2 text-center">
               <img v-bind:src="lists.badge.image" alt="">
            </div>
            <div class="col-md-8 name-clan">
               <h1>{{ lists.name }}</h1>
               <h3>#{{ lists.tag }}</h3>
            </div>
            <div class="col-md-2 button-clan">
               <a href="https://link.clashroyale.com/invite/clan/es?tag=22CRJCRC&token=w7w2s32y&platform=android" class="btn btn-light">Entra a nuestro clan</a>
            </div>
         </div>

         <div class="row">
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <h2>{{ lists.score }}</h2>
                        <h4>Trofeos</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/trophy-ribbon.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <h2>{{ lists.requiredScore }}</h2>
                        <h4>Trofeos requeridos</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/trophy.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <h2>{{ lists.donations }}</h2>
                        <h4>Donaciones</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/cards.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <h2>{{ lists.memberCount }} / 50</h2>
                        <h4>Miembros</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/social.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <div v-if="lists.clanChest.status == 'completed'">
                           <h2>Completo</h2>
                        </div>
                        <div v-else-if="lists.clanChest.status == 'inactive'">
                           <h2>Inactivo</h2>
                        </div>
                        <div v-else-if="lists.clanChest.status == 'active'">
                           <h2>Activo</h2>
                        </div>
                        <h4>Cofre del Clan</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/chest-clan.png" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mt-3">
               <div class="card">
                  <div class="card-body d-flex justify-content-between align-items-center">
                     <div class="info-card">
                        <h2>{{ lists.location.name }}</h2>
                        <h4>Región</h4>
                     </div>
                     <div class="image-card">
                        <img src="images/static/mx.svg" alt="" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
         </div>

<section class="roster">
   <div class="table-responsive-sm">
      <table class="table table-striped">
         <thead class="thead-dark">
            <tr>
               <th class="text-center">Rank</th>
               <th>Nombre</th>
               <th>Rol</th>
               <th>Trofeos</th>
               <th>Arena</th>
               <th></th>
               <th>Coronas</th>
               <th>Donaciones</th>
            </tr>
         </thead>
         <tbody>

            <tr v-for="user in members">
               <td class="text-center">{{ user.rank }}</td>
               <td>{{ user.name }}</td>
               <td>
                  <div v-if="user.role == 'leader'">
                     Líder
                  </div>
                  <div v-else-if="user.role == 'coLeader'">
                     Colider
                  </div>
                  <div v-else-if="user.role == 'elder'">
                     Veterano
                  </div>
                  <div v-else-if="user.role == 'member'">
                     Miembro
                  </div>
               </td>
               <td>{{ user.trophies }}</td>
               <td>
                  <div v-if="user.arena.arenaID == 21">
                     Campeones definitivos
                  </div>
                  <div v-else-if="user.arena.arenaID == 20">
                     Grandes campeones
                  </div>
                  <div v-else-if="user.arena.arenaID == 19">
                     Campeones
                  </div>
                  <div v-else-if="user.arena.arenaID == 18">
                     Maestros III
                  </div>
                  <div v-else-if="user.arena.arenaID == 17">
                     Maestros II
                  </div>
                  <div v-else-if="user.arena.arenaID == 16">
                     Maestros I
                  </div>
                  <div v-else-if="user.arena.arenaID == 15">
                     Combatientes III
                  </div>
                  <div v-else-if="user.arena.arenaID == 14">
                     Combatientes II
                  </div>
                  <div v-else-if="user.arena.arenaID == 13">
                     Combatientes I
                  </div>
                  <div v-else-if="user.arena.arenaID === 12">
                     Arena Legendaria
                  </div>
                  <div v-else-if="user.arena.arenaID == 11">
                     Electrovalle
                  </div>
                  <div v-else-if="user.arena.arenaID == 10">
                     Montepuerco
                  </div>
                  <div v-else-if="user.arena.arenaID == 9">
                     Arena selvática
                  </div>
                  <div v-else-if="user.arena.arenaID == 8">
                     Pico helado
                  </div>
                  <div v-else-if="user.arena.arenaID == 7">
                     Valle de hechizos
                  </div>
                  <div v-else-if="user.arena.arenaID == 6">
                     Taller de constructor
                  </div>
                  <div v-else-if="user.arena.arenaID == 5">
                     Valle de hechizos
                  </div>
                  <div v-else-if="user.arena.arenaID === 4">
                     Fuerte del P.E.K.K.A.
                  </div>
                  <div v-else-if="user.arena.arenaID === 3">
                     Coliseo bárbaro
                  </div>
                  <div v-else-if="user.arena.arenaID === 2">
                     Foso de huesos
                  </div>
                  <div v-else-if="user.arena.arenaID === 1">
                     Estadio duende
                  </div>
                  <!-- <div v-else>

               </div> --></td>
               <td class="text-center">
                  <div v-if="user.arena.arenaID == 21">
                     <img class="arena-image" src="images/arenas/arena21.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 20">
                     <img class="arena-image" src="images/arenas/arena20.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 19">
                     <img class="arena-image" src="images/arenas/arena19.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 18">
                     <img class="arena-image" src="images/arenas/arena18.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 17">
                     <img class="arena-image" src="images/arenas/arena17.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 16">
                     <img class="arena-image" src="images/arenas/arena16.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 15">
                     <img class="arena-image" src="images/arenas/arena15.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 14">
                     <img class="arena-image" src="images/arenas/arena14.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 13">
                     <img class="arena-image" src="images/arenas/arena13.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 12">
                     <img class="arena-image" src="images/arenas/arena12.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 11">
                     <img class="arena-image" src="images/arenas/arena11.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 10">
                     <img class="arena-image" src="images/arenas/arena10.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 9">
                     <img class="arena-image" src="images/arenas/arena9.png" alt="">
                  </div>
                  <div v-if="user.arena.arenaID === 8">
                     <img class="arena-image" src="images/arenas/arena8.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 7">
                     <img class="arena-image" src="images/arenas/arena7.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 6">
                     <img class="arena-image" src="images/arenas/arena6.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 5">
                     <img class="arena-image" src="images/arenas/arena5.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 4">
                     <img class="arena-image" src="images/arenas/arena4.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 3">
                     <img class="arena-image" src="images/arenas/arena3.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 2">
                     <img class="arena-image" src="images/arenas/arena2.png" alt="">
                  </div>
                  <div v-else-if="user.arena.arenaID == 1">
                     <img class="arena-image" src="images/arenas/arena1.png" alt="">
                  </div>
               </td>
               <td>{{ user.clanChestCrowns }}</td>
               <td>{{ user.donations }}</td>
            </tr>
         </tbody>
      </table>
   </div>
</section>

      </div>
   </div>

   <footer class="footer">
      <div class="container">
        <span>Creado por <a href="http://cv.luisramirez.me">Luis Ramirez</a></span>
      </div>
    </footer>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.0/vue.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.min.js"></script>
   <script type="text/javascript">
      var urlUsers = 'clan.json';
      new Vue({
         el: '#main',
         created: function () {
            this.getUsers();
         },
         data: {
            lists: [],
            members:[]
         },
         methods: {
            getUsers: function() {
               axios.get(urlUsers).then(response => {
                  this.lists = response.data,
                  this.members= response.data.members
               });
            }
         }
      });
   </script>
</body>

</html>
