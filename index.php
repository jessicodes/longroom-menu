<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    // connect to db via notorm/pdo
    include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");
  ?>
  <meta charset="UTF-8">
  <link href="/resources/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" media="screen" href="/resources/css/layout.css" type="text/css" />
</head>
<body>

<div id="app">
  <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <router-link class="navbar-brand" :to="{ name: 'BuildMenu' }">Long Room</router-link>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'BuildMenu' }">Current Menu</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'AddBeer' }">Add Beer</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'AddBrewery' }">Add Brewery</router-link>
        </li>
      </ul>
    </div>
  </nav>

  <router-view />

</div>

<!-- ADD A BEER -->
<template id="add-beer">
  <div class="container">

    <h1 v-if="beer.id">Edit Beer</h1>
    <h1 v-else>Add a Beer</h1>

    <div v-if="!postStatus">
      <form id="form" method="post" v-on:submit.prevent="validateForm">
        <div class="form-group" v-bind:class="{ 'has-warning': attemptSubmit && missingName }">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" id="name" v-model="beer.name" />
          <span id="helpBlock" class="help-block" v-if="attemptSubmit && missingName">This field is required.</span>
        </div>
        <div class="form-group">
          <label for="brewery">Brewery</label><br />
          <v-select :options="breweryOptions" v-model="beer.brewery"></v-select>
        </div>
        <div class="form-group">
          <label for="style">Beer Style</label><br />
          <v-select :options="styleOptions" v-model="beer.style"></v-select>
        </div>
        <div class="form-group">
          <label for="glassware">Glassware</label><br />
          <v-select :options="glasswareOptions" v-model="beer.glassware"></v-select>
        </div>
        <div class="form-group">
          <label for="abv">ABV</label><br />
          <input type="number" class="form-control" name="abv" id="abv" v-model="beer.abv" min="0" step=".01" />
          <small  class="form-text text-muted">
            Do not include %
          </small>
        </div>
        <div class="form-group" v-bind:class="{ 'has-warning': attemptSubmit && missingDescription }">
          <label for="description">Description</label><br />
          <textarea class="form-control" name="description" id="description" rows="5" v-model="beer.description"></textarea>
          <span id="helpBlock" class="help-block" v-if="attemptSubmit && missingDescription">This field is required.</span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <div v-if="postStatus">
      <div class="alert alert-success" role="alert">Success!</div>
      <button type="submit" class="btn btn-primary" v-on:click="startOver">Add Another Beer</button>
    </div>
  </div>
</template>
<!-- ADD ADD A BEER -->

<!-- ADD BREWERY -->
<template id="add-brewery">
  <div class="container">
    <h1>Add Brewery</h1>
    <div v-if="!postStatus">
      <form id="form" method="post" v-on:submit.prevent="validateForm">
        <div class="form-group" v-bind:class="{ 'has-warning': attemptSubmit && missingName }">
          <label for="name">Brewery Name</label>
          <input type="text" class="form-control" name="name" id="name" v-model="name" />
          <span id="helpBlock" class="help-block" v-if="attemptSubmit && missingName">This field is required.</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-warning': attemptSubmit && missingLocation }">
          <label for="location">Brewery Location</label>
          <input type="text" class="form-control" name="location" id="location" v-model="location" />
          <small  class="form-text text-muted">
            Ex. Chicago, IL
          </small>
          <span id="helpBlock" class="help-block" v-if="attemptSubmit && missingLocation">This field is required.</span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <div v-if="postStatus">
      <div class="alert alert-success" role="alert">The brewery was successfully added.</div>
      <button type="submit" class="btn btn-primary" v-on:click="startOver">Add Another Brewery</button>
    </div>
  </div>
</template>
<!-- END ADD A BREWERY -->

<!-- BUILD YOUR MENU -->
<template id="build-menu">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8">

        <h1>Beer Menu</h1>

        <div class="form-group">
          <label for="searchBeer">Search a beer</label>
          <input v-model="search" type="email" class="form-control" id="searchBeer" />
        </div>

        <p>Displaying {{ filteredBeers.length }} beers, filtered by <strong>{{ search }}</strong></p>

        <div class="panel-heading"><i v-show="loading">...Loading beers...</i></div>
        <div v-for="beer in filteredBeers" class="beerCard">
          <div class="row"> <!--align-items-center-->
            <div class="col-8">
              <h4>{{ beer.brewery.label }}</h4>
              <h6>{{ beer.name }}</h6>
              {{ beer.description }}
              ----
              {{ beer.style.label }}
              ----
              {{ beer.glassware.label }}
            </div>
            <div class="col-2">
              <router-link :to="{ name: 'EditBeer', params: { id: beer.id }}"><i class="fa fa-pencil-square-o"></i></router-link>
            </div>
            <div class="col-2">
              <a class="addBeer" v-on:click="addBeer(beer)"><i class="fa fa-plus-square-o"></i></a>
            </div>
          </div>
        </div>

      </div>
      <div class="col-12 col-md-4">

        <div class="activeMenu-wrapper">
          <h3>Today's Menu</h3>
          <div class="activeMenu">

            <draggable class="dragArea" v-bind:list="activeBeers" v-bind:options="{sort: true, draggable: '.activeMenu-item'}" v-on:change="draggableUpdateDrop" v-bind:move="draggableMove">
              <article v-for="(beer, index) in activeBeers" class="activeMenu-item">
                <p>{{ beer.brewery.label }} <strong>{{ beer.name }}</strong>
                  <a class="removeBeer" v-on:click="removeBeer(index)"><i class="fa fa-minus"></i></a>
                </p>
              </article>
            </draggable>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<!-- END BUILD YOUR MENU -->

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