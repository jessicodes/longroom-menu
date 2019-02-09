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
  <main class="container main main--half">
    <div class="main__content">

      <h1 v-if="beer.id">Edit This Beer</h1>
      <h1 v-else>Add a Beer</h1>

      <div v-if="!postStatus">

        <div class="errors" v-if="errors.length">
          <b>Please correct the following error(s):</b>
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
        </div>

        <form id="form" method="post" v-on:submit.prevent="validateForm">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" v-model="beer.name" />
          </div>
          <div class="form-group">
            <label for="brewery">Brewery</label><br />
            <v-select :options="breweryOptions" v-model="beer.brewery"></v-select>
          </div>
          <div class="form-group">
            <label for="style">Beer Style</label>
            <input type="text" class="form-control" name="style" id="style" v-model="beer.style" />
          </div>
          <div class="form-group">
            <label for="glassware">Glassware</label><br />
            <v-select :options="glasswareOptions" v-model="beer.glassware"></v-select>
          </div>
          <div class="form-group">
            <label for="abv">ABV</label><br />
            <input type="number" class="form-control" name="abv" id="abv" v-model="beer.abv" min="0" step=".01" />
          </div>
          <div class="form-group">
            <label for="price">Price</label><br />
            <input type="number" class="form-control" name="price" id="price" v-model="beer.price" min="0" step="1" />
          </div>
          <div class="form-group">
            <label for="description">Description</label><br />
            <textarea class="form-control" name="description" id="description" rows="5" v-model="beer.description"></textarea>
          </div>
          <button type="submit" class="button">Save Beer</button>
        </form>
      </div>
      <div v-if="postStatus">
        <div class="alert alert-success" role="alert">Success!</div>
        <br />
        <router-link :to="{ name: 'BuildMenu'}" class="button button-secondary">< Back to Menu</router-link>
        <button type="submit" class="button" v-on:click="startOver">Add a New Beer</button>
      </div>
    </div>
  </main>
</template>
<!-- ADD ADD A BEER -->

<!-- ADD BREWERY -->
<template id="add-brewery">
  <main class="container main main--half">
    <div class="main__content">

      <h1 v-if="editable_id">Edit This Brewery</h1>
      <h1 v-else>Add a Brewery</h1>

      <div v-if="!postStatus">

        <div class="errors" v-if="errors.length">
          <b>Please correct the following error(s):</b>
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
        </div>

        <form id="form" method="post" v-on:submit.prevent="validateForm">
          <div class="form-group">
            <label for="name">Brewery Name</label>
            <input type="text" class="form-control" name="name" id="name" v-model="name" />
          </div>
          <div class="form-group">
            <label for="location">Brewery Location</label>
            <input type="text" class="form-control" name="location" id="location" v-model="location" />
          </div>
          <button type="submit" class="button">Save Brewery</button>
        </form>
      </div>
      <div v-if="postStatus">
        <div class="alert alert-success" role="alert">Success!</div><br />
        <router-link :to="{ name: 'BuildMenu'}" class="button button-secondary">< Back to Menu</router-link>
        <button type="submit" class="button" v-on:click="startOver">Add a New Brewery</button>
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
        <label for="searchBeer">Search for a beer</label>
        <input v-model="search" type="email" class="form-control" id="searchBeer" />
      </div>

      <p class="searchTotal">Displaying {{ filteredBeers.length }} beers</p>

      <div class="panel-heading"><i v-show="loading">...Loading beers...</i></div>

      <section class="draftDetailsList">
        <div class="listTitles">
          <h2>Draft<span>Detailed</span></h2>
          <div class="listTitle">Type</div>
          <div class="listTitle">From</div>
          <div class="listTitle">Served</div>
          <div class="listTitle">ABV</div>
          <div class="listTitle">Price</div>
        </div>
        <article v-for="beer in filteredBeers" class="draftDetail" title="Add Beer!">

          <div class="draftDetail__grid" v-on:click="addBeer(beer)">
            <header class="draftDetail__header">
              <h3>{{ beer.brewery.label }}</h3>
            </header>
            <div class="draftDetail__col draftDetail__col--1">
              <h4>{{ beer.name }}</h4>
              <p class="draftDetail__description">{{ beer.description }}</p>
            </div>
            <div class="draftDetail__col draftDetail__col--2">
              <span class="draftDetail__style">{{ beer.style }}</span>
            </div>
            <div class="draftDetail__col draftDetail__col--3">
              <span class="draftDetail__location">{{ beer.brewery.location }}</span>
            </div>
            <div class="draftDetail__col draftDetail__col--4">
              <span class="draftDetail__glassware">{{ beer.glassware.label }}</span>
            </div>
            <div class="draftDetail__col draftDetail__col--5">
              <span class="draftDetail__abv">{{ beer.abv }}%</span>
            </div>
            <div class="draftDetail__col draftDetail__col--6">
              <span class="draftDetail__price">{{ beer.price|toCurrency }}</span>
            </div>
          </div>

          <!-- Edit Options -->
          <div class="edit__options">
            <ul>
              <li><router-link :to="{ name: 'EditBeer', params: { id: beer.id }}">Edit Beer</router-link></li>
              <li><router-link :to="{ name: 'EditBrewery', params: { id: beer.brewery.id }}">Edit Brewery</router-link></li>
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
            <div class="panel-heading"><i v-show="activeBeersLoading">...Loading beers...</i></div>
            <draggable class="dragArea" v-bind:list="activeBeers" v-bind:options="{sort: true, draggable: '.activeBeer'}" v-on:change="draggableUpdateDrop" v-bind:move="draggableMove">
              <article v-for="(beer, index) in activeBeers" class="activeBeer">

                <!-- Edit Options -->
                <div class="edit__options">
                  <ul>
                    <li><router-link :to="{ name: 'EditBeer', params: { id: beer.id }}">Edit Beer</router-link></li>
                    <li><router-link :to="{ name: 'EditBrewery', params: { id: beer.brewery.id }}">Edit Brewery</router-link></li>
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
                  <span class="activeBeer__beer">{{ beer.name }} <span>{{ beer.price|toCurrency }}</span></span>
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
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.0/vue.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/2.5.3/vue-router.min.js"></script>

<!-- Vue Select -->
<script src="https://unpkg.com/vue-select@latest"></script>

<!-- Axios :: XMLHttpRequests -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.js"></script>

<!-- CDNJS :: Sortable (https://cdnjs.com/) -->
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>

<!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.16.0/vuedraggable.min.js"></script>

<!-- Custom Scripts -->
<script src="/resources/js/actions.js"></script>
<script src="/resources/js/main.js"></script>
<script src="/resources/js/filters.js"></script>

</body>
</html>