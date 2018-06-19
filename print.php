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
      <article v-for="(beer, index) in activeBeers" class="activeBeer">
        <div class="activeBeer__col activeBeer__col--1">
          <span class="activeBeer__brewery">{{ beer.brewery.label }}</span>
        </div>
        <div class="activeBeer__col activeBeer__col--2">
          <span class="activeBeer__beer">{{ beer.name }} <span>${{ beer.price }}</span></span>
        </div>
        <div class="activeBeer__col activeBeer__col--3">
          <span class="activeBeer__glassIcon">{{ beer.glassware.icon }}</span>
        </div>
      </article>
    </div>
  </div>

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