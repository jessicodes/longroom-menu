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

  <div class="printableH1 align-right">
    <img src="resources/images/DraftBeerTitle.gif" title="DRAFT LIST" alt="DRAFT LIST" class="print-title" />
  </div>

  <section class="printableList printableList--draftList">
    <table>
      <tr class="listTitles">
        <th class="listTitle listTitle--header"><h2>Draft<span>List</span></h2></th>
        <th class="listTitle listTitle--brewery">Brewery</th>
        <th class="listTitle">Beer</th>
        <th>&nbsp;</th>
      </tr>
      <tr v-for="(beer, index) in activeBeers" class="draftListItem">
        <td colspan="2" class="draftListItem__brewery">{{ beer.brewery.label }}</td>
        <td class="draftListItem__beer">{{ beer.name }} <span>{{ beer.price|toCurrency }}</span></td>
        <td class="draftListItem__glassIcon">{{ beer.glassware.icon }}</td>
      </tr>
    </table>
    <img src="resources/images/Key.png" class="print-key" />
  </section>

  <div class="page-break"></div>

  <div class="printableH1 align-left">
    <img src="resources/images/DraftBeerTitle.gif" title="DRAFT BEER" alt="DRAFT BEER" class="print-title" />
  </div>
  
  <section class="printableList printableList--draftDetailsList">
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle"><span class="shrink">Type</span></th>
        <th class="listTitle"><span class="shrink">From</span></th>
        <th class="listTitle"><span class="shrink">Served</span></th>
        <th class="listTitle"><span class="shrink">ABV</span></th>
        <th class="listTitle"><span class="shrink">Price</span></th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(0,6)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style"><span class="shrink">{{ beer.style }}</span></td>
        <td class="draftDetail__location"><span class="shrink">{{ beer.brewery.location }}</span></td>
        <td class="draftDetail__glassware"><span class="shrink">{{ beer.glassware.label }}</span></td>
        <td class="draftDetail__abv"><span class="shrink">{{ beer.abv }}%</span></td>
        <td class="draftDetail__price"><span class="shrink">{{ beer.price|toCurrency }}</span></td>
      </tr>
    </table>
  </section>

  <div class="page-break"></div>

  <section class="printableList printableList--draftDetailsList">
  
    <div class="printableH1 align-right">
      <img src="resources/images/DraftBeerTitle.gif" title="DRAFT BEER" alt="DRAFT BEER" class="print-title" />
    </div>
  
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle"><span class="shrink">Type</span></th>
        <th class="listTitle"><span class="shrink">From</span></th>
        <th class="listTitle"><span class="shrink">Served</span></th>
        <th class="listTitle"><span class="shrink">ABV</span></th>
        <th class="listTitle"><span class="shrink">Price</span></th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(6,12)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style"><span class="shrink">{{ beer.style }}</span></td>
        <td class="draftDetail__location"><span class="shrink">{{ beer.brewery.location }}</span></td>
        <td class="draftDetail__glassware"><span class="shrink">{{ beer.glassware.label }}</span></td>
        <td class="draftDetail__abv"><span class="shrink">{{ beer.abv }}%</span></td>
        <td class="draftDetail__price"><span class="shrink">{{ beer.price|toCurrency }}</span></td>
      </tr>
    </table>
  </section>

  <div class="page-break"></div>

  <div class="printableH1 align-left">
    <img src="resources/images/DraftBeerTitle.gif" title="DRAFT BEER" alt="DRAFT BEER" class="print-title" />
  </div>

  <section class="printableList printableList--draftDetailsList">
    <table>
      <tr class="listTitles">
        <th><h2>Draft<span>Detailed</span></h2></th>
        <th class="listTitle"><span class="shrink">Type</span></th>
        <th class="listTitle"><span class="shrink">From</span></th>
        <th class="listTitle"><span class="shrink">Served</span></th>
        <th class="listTitle"><span class="shrink">ABV</span></th>
        <th class="listTitle"><span class="shrink">Price</span></th>
      </tr>
      <tr v-for="(beer, index) in sliceItems(12,19)" class="draftDetail">
        <td class="draftDetail__description">
          <h3>{{ beer.brewery.label }}</h3>
          <h4>{{ beer.name }}</h4>
          <p>{{ beer.description }}</p>
        </td>
        <td class="draftDetail__style"><span class="shrink">{{ beer.style }}</span></td>
        <td class="draftDetail__location"><span class="shrink">{{ beer.brewery.location }}</span></td>
        <td class="draftDetail__glassware"><span class="shrink">{{ beer.glassware.label }}</span></td>
        <td class="draftDetail__abv"><span class="shrink">{{ beer.abv }}%</span></td>
        <td class="draftDetail__price"><span class="shrink">{{ beer.price|toCurrency }}</span></td>
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
<script src="/resources/js/filters.js"></script>

</body>
</html>