<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  // connect to db via notorm/pdo
  include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");
  ?>
  <meta charset="UTF-8">
  <link rel="stylesheet" media="screen" href="/resources/css/print.css" type="text/css" />
</head>
<body>

<div id="print">

  <h1>DRAFT LIST</h1>

  <div class="activeMenu-wrapper">
    <h3 class="activeMenu__title listTitle listTitle--large">Draft<span>List</span></h3>
    <div class="activeMenu">

      <draggable class="dragArea" v-bind:list="activeBeers" v-bind:options="{sort: true, draggable: '.activeBeer'}" v-on:change="draggableUpdateDrop" v-bind:move="draggableMove">
        <article v-for="(beer, index) in activeBeers" class="activeBeer">
          <div class="editOptions">
            <ul>
              <li><router-link :to="{ name: 'EditBeer', params: { id: beer.brewery.id }}">Edit<br />Brewery</router-link></li>
              <li><router-link :to="{ name: 'EditBeer', params: { id: beer.id }}">Edit<br />Beer</router-link></li>
              <li><a class="removeBeer" v-on:click="removeBeer(index)"><i class="fa fa-minus"></i></a></li>
            </ul>
          </div>
          <div class="activeBeer__col activeBeer__col--1">
            <span class="activeBeer__index">{{ index + 1 }}</span>
            <span class="activeBeer__brewery">{{ beer.brewery.label }}</span>
          </div>
          <div class="activeBeer__col activeBeer__col--2">
            <span class="activeBeer__beer">{{ beer.name }} <span>{{ beer.price }}$6</span></span>
          </div>
          <div class="activeBeer__col activeBeer__col--3">
            <span class="activeBeer__glassIcon">***</span>
          </div>
        </article>
      </draggable>

    </div>
  </div>

{{ message }}

</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>

<!-- Front End -->
<script src="https://use.fontawesome.com/0828c6b60a.js"></script>

<!-- Vue Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.0/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/2.5.3/vue-router.js"></script>

<!-- Vue Select -->
<script src="https://unpkg.com/vue-select@latest"></script>

<!-- Axios :: XMLHttpRequests -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.js"></script>

<!-- CDNJS :: Sortable (https://cdnjs.com/) -->
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>

<!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.16.0/vuedraggable.min.js"></script>

<!-- Custom Scripts -->
<script src="/resources/js/main.js"></script>

</body>
</html>