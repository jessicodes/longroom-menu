<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    // connect to db via notorm/pdo
    include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");
  ?>
  <meta charset="UTF-8">
  <link rel="stylesheet" media="screen" href="/resources/css/layout.css" type="text/css" />
</head>
<body>

<div id="app" class="layout">

  <header class="header">
    <div class="container header__container">

      <div class="logo">
        <router-link class="navbar-brand" :to="{ name: 'BuildMenu' }"><img src="/resources/images/LongRoomLogo.png" alt="Long Room Chicago" class="logo__image"></router-link>
      </div>

      <nav class="navigation">
        <ul class="navigation__items">
          <li class="navigation__item">
            <router-link class="navigation__link" :to="{ name: 'BuildMenu' }">Current Menu</router-link>
          </li>
          <li class="navigation__item">
            <router-link class="navigation__link" :to="{ name: 'AddBeer' }">Add Beer</router-link>
          </li>
          <li class="navigation__item">
            <router-link class="navigation__link" :to="{ name: 'AddBrewery' }">Add Brewery</router-link>
          </li>
        </ul>
      </nav>

    </div>
  </header>

  <router-view />

</div>

<!-- ADD A BEER -->
<template id="add-beer">
  <main class="container main main--full">
    <div class="main__content">

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
          <div class="form-group">
            <label for="price">Price</label><br />
            <input type="number" class="form-control" name="price" id="price" v-model="beer.price" min="0" step=".01" />
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
  </main>
</template>
<!-- ADD ADD A BEER -->

<!-- ADD BREWERY -->
<template id="add-brewery">
  <main class="container main main--full">
    <div class="main__content">
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
  </main>
</template>
<!-- END ADD A BREWERY -->

<!-- BUILD YOUR MENU -->
<template id="build-menu">
  <main class="container main main--2cols">
    <div class="main__content">
      <h1>Beer Menu</h1>

      <div class="form-group">
        <label for="searchBeer">Search a beer</label>
        <input v-model="search" type="email" class="form-control" id="searchBeer" />
      </div>

      <p>Displaying {{ filteredBeers.length }} beers, filtered by <strong>{{ search }}</strong></p>

      <div class="panel-heading"><i v-show="loading">...Loading beers...</i></div>

      <section class="beerCards">
        <div class="listTitles">
          <h2>Draft<span>Detailed</span></h2>
          <div class="listTitle">Type</div>
          <div class="listTitle">From</div>
          <div class="listTitle">Served</div>
          <div class="listTitle">ABV</div>
          <div class="listTitle">Price</div>
        </div>
        <article v-for="beer in filteredBeers" class="beerCard" v-on:click="addBeer(beer)" title="Add Beer!">
          <header class="beerCard__header">
            <h3>{{ beer.brewery.label }}</h3>
          </header>
          <div class="beerCard__col beerCard__col--1">
            <h4>{{ beer.name }}</h4>
            <p class="beerCard__description">{{ beer.description }}</p>
          </div>
          <div class="beerCard__col beerCard__col--2">
            <span class="beerCard__style">{{ beer.style.label }}</span>
          </div>
          <div class="beerCard__col beerCard__col--3">
            <span class="beerCard__location">{{ beer.brewery.location }}</span>
          </div>
          <div class="beerCard__col beerCard__col--4">
            <span class="beerCard__glassware">{{ beer.glassware.label }}</span>
          </div>
          <div class="beerCard__col beerCard__col--5">
            <span class="beerCard__abv">{{ beer.abv }}%</span>
          </div>
          <div class="beerCard__col beerCard__col--6">
            <span class="beerCard__price">${{ beer.price }}</span>
          </div>

          <!-- Edit Options -->
          <div class="edit__options">
            <ul>
              <li><router-link :to="{ name: 'EditBeer', params: { id: beer.id }}">Edit Beer</router-link></li>
              <li><router-link :to="{ name: 'EditBeer', params: { id: beer.brewery.id }}">Edit Brewery</router-link></li>
            </ul>
          </div>
          <i class="fa fa-pencil js-show-edit-options edit__icon" aria-hidden="true"></i>
          <!-- /Edit Options -->

        </article>
      </section>
    </div>

    <div class="main__right">
      <aside class="activeMenu">

        <div class="activeMenu-wrapper">
          <h2 class="activeMenu__title">Draft<span>List</span></h2>
          <div class="activeMenu">

            <draggable class="dragArea" v-bind:list="activeBeers" v-bind:options="{sort: true, draggable: '.activeBeer'}" v-on:change="draggableUpdateDrop" v-bind:move="draggableMove">
              <article v-for="(beer, index) in activeBeers" class="activeBeer">

                <!-- Edit Options -->
                <div class="edit__options">
                  <ul>
                    <li><router-link :to="{ name: 'EditBeer', params: { id: beer.id }}">Edit Beer</router-link></li>
                    <li><router-link :to="{ name: 'EditBeer', params: { id: beer.brewery.id }}">Edit Brewery</router-link></li>
                    <li><a v-on:click="removeBeer(index)">Remove Beer</a></li>
                  </ul>
                </div>
                <i class="fa fa-pencil js-show-edit-options edit__icon" aria-hidden="true"></i>
                <!-- /Edit Options -->

                <div class="activeBeer__col activeBeer__col--1">
                  <span class="activeBeer__index">{{ index + 1 }}</span>
                  <span class="activeBeer__brewery">{{ beer.brewery.label }}</span>
                </div>
                <div class="activeBeer__col activeBeer__col--2">
                  <span class="activeBeer__beer">{{ beer.name }} <span>{{ beer.price }}$6</span></span>
                </div>
                <div class="activeBeer__col activeBeer__col--3">
                  <span class="activeBeer__glassIcon">{{ beer.glassware.icon }}</span>
                </div>
              </article>
            </draggable>

          </div>
        </div>

        <a href="/print.php" class="button">Print Menus</a>

      </aside>
    </div>

  </main>
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
<script src="/resources/js/actions.js"></script>

</body>
</html>