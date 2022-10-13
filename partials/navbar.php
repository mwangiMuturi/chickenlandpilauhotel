<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ms+Madi&display=swap" rel="stylesheet">
<style>
    .navbar{
        font-family: 'Roboto', sans-serif;
    }
    .active_a{
        border: 0.01px solid #ffb703;
        
        background-color: #fcbf49;
        color: white;
    }
    .list>li>a{
      height: 100%;

width: 200px;  
text-align: center; 

    }
    .nothover:hover{
    background-color: #0d1b2a;
    color: white;
    }

    .list{
      display: flex;
      width: 80%; 
justify-content: space-aroun;
    }
    .cont{
      margin-left: 30px;
      
      

    }
    .navba{
      padding: 0px;
    }
    .branding{
      font-family: 'Ms Madi', cursive;
      color: #283618;
      font-weight: bold;
    }
</style>
<nav class="navbar navbar-expand-lg bg-light mb-1 navba">
  <div class="container-fluid cont pl-3">
    <a class="navbar-brand branding fs-3" href="dashboard.php">ChickenLand</a>
   
    <div class=" container" >
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-arnd list fs-5">
        <li class="nav-item">
          <a class="nav-link nothover" aria-current="page" href="index.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nothover" href="view_orders.php">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nothover" href="sentiment.php">Reviews</a>
        </li>  
       
      </ul>
        </div>
    

  </div>
</nav>

<script>
    const activePage=window.location
    console.log(activePage)

    const navlinks=document.querySelectorAll('nav a').
    forEach(link=>{
        if (link.href.includes(`${activePage}`)){
            console.log(`${activePage}`)
            link.classList.add('active_a')
            link.classList.remove('nothover')

        }
    })
</script>
