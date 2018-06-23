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
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle">Type</th>
        <th class="listTitle">From</th>
        <th class="listTitle">Served</th>
        <th class="listTitle">ABV</th>
        <th class="listTitle">Price</th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(0,6)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style">{{ beer.style.label }}</td>
        <td class="draftDetail__location">{{ beer.brewery.location }}</td>
        <td class="draftDetail__glassware">{{ beer.glassware.label }}</td>
        <td class="draftDetail__abv">{{ beer.abv }}%</td>
        <td class="draftDetail__price">${{ beer.price }}</td>
      </tr>
    </table>
  </section>

  <div class="page-break"></div>

  <h1>DRAFT BEER</h1>

  <section class="draftDetailsList">
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle">Type</th>
        <th class="listTitle">From</th>
        <th class="listTitle">Served</th>
        <th class="listTitle">ABV</th>
        <th class="listTitle">Price</th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(7,13)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style">{{ beer.style.label }}</td>
        <td class="draftDetail__location">{{ beer.brewery.location }}</td>
        <td class="draftDetail__glassware">{{ beer.glassware.label }}</td>
        <td class="draftDetail__abv">{{ beer.abv }}%</td>
        <td class="draftDetail__price">${{ beer.price }}</td>
      </tr>
    </table>
  </section>

  <div class="page-break"></div>

  <h1>DRAFT BEER</h1>

  <section class="draftDetailsList">
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle">Type</th>
        <th class="listTitle">From</th>
        <th class="listTitle">Served</th>
        <th class="listTitle">ABV</th>
        <th class="listTitle">Price</th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(14,20)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style">{{ beer.style.label }}</td>
        <td class="draftDetail__location">{{ beer.brewery.location }}</td>
        <td class="draftDetail__glassware">{{ beer.glassware.label }}</td>
        <td class="draftDetail__abv">{{ beer.abv }}%</td>
        <td class="draftDetail__price">${{ beer.price }}</td>
      </tr>
    </table>
  </section>

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