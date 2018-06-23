<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  // connect to db via notorm/pdo
  include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");
  ?>
  <meta charset="UTF-8">
  <link rel="stylesheet" media="all" href="/resources/css/print.css" type="text/css" />
</head>
<body>

<div id="print">

  <h1>DRAFT LIST</h1>

<!--    <h3 class="activeMenu__title listTitle listTitle--large">Draft<span>List</span></h3>-->
  <div class="draftList">

    <h2 class="listTitle-col">Draft<span>List</span></h2>
    <div class="listTitle listTitle-col listTitle-col--right">Brewery</div>
    <div class="listTitle listTitle-col vertical-borders">Beer</div>
    <div class="listTitle-col">&nbsp;</div>

    <template v-for="(beer, index) in activeBeers">
      <div class="draftListItem__col draftListItem__col--1">
        <span class="draftListItem__brewery">{{ beer.brewery.label }}</span>
      </div>
      <div class="draftListItem__col draftListItem__col--2 vertical-borders">
        <span class="draftListItem__beer">{{ beer.name }} <span>${{ beer.price }}</span></span>
      </div>
      <div class="draftListItem__col draftListItem__col--3">
        <span class="draftListItem__glassIcon">{{ beer.glassware.icon }}</span>
      </div>
    </template>
  </div>

  <div class="page-break"></div>

  <h1>DRAFT BEER</h1>

  <section class="draftDetailsList">
    <div class="listTitles">
      <h2>Draft<span>Detailed</span></h2>
      <div class="listTitle">Type</div>
      <div class="listTitle">From</div>
      <div class="listTitle">Served</div>
      <div class="listTitle">ABV</div>
      <div class="listTitle">Price</div>
    </div>
    <article v-for="(beer, index) in sliceItems(0,6)" class="draftDetail">
      <div class="draftDetail__grid" v-on:click="addBeer(beer)">
        <header class="draftDetail__header">
          <h3>{{ beer.brewery.label }}</h3>
        </header>
        <div class="draftDetail__col draftDetail__col--1">
          <h4>{{ beer.name }}</h4>
          <p class="draftDetail__description">{{ beer.description }}</p>
        </div>
        <div class="draftDetail__col draftDetail__col--2">
          <span class="draftDetail__style">{{ beer.style.label }}</span>
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
          <span class="draftDetail__price">${{ beer.price }}</span>
        </div>
      </div>
    </article>
  </section>

  <div class="page-break"></div>

  <h1>DRAFT BEER</h1>

<!--  <article v-for="(beer, index) in sliceItems(7,13)" class="beerCard">-->
<!--  <article v-for="(beer, index) in sliceItems(14,20)" class="beerCard">-->

</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>

<!-- Vue Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.0/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/2.5.3/vue-router.js"></script>

<!-- Axios :: XMLHttpRequests -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.js"></script>

<!-- Custom Scripts -->
<script src="/resources/js/print_vue.js"></script>

</body>
</html>