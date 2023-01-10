<div class="card" style="width:15rem;  ">
    <img style="height: 100; background-size:contain" src="<?php echo $img?>" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title"><?php $title?></h5>
      <p class="card-text"> <?php echo $desc ?></p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><?php echo $price ?></li>
      
    </ul>
    <div class="card-body text-center kadi" id="card">
      <button class="btn btn-success fw-bolder">+</button>
      <a href="#" class="card-link btn btn-primary">Add</a>
      <button class="btn btn-danger fw-bolder">-</button>

    </div>
  </div>