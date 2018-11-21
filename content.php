<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="images/sciencesu.png" width="650" height="366" style= margin:auto>
                </div>
                <div class="item">
                  <img src="images/sciencesu2.png" width="650" height="366" style= margin:auto >
                </div>
              </div>

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Précédent</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Suivant</span>
              </a>
            </div>
            <hr>
            <?php
               $articles = bdd_article();
                while($article = $articles->fetch()){
                ?>
                    <h2>
                        <a href="artsolo.php?id=<?php echo $article['id']; ?>">
                           <?php echo $article['titre']; ?>
                        </a>
                    </h2>
                    <p class="lead">
                    by <a href="artsolo.php?id=
                        <?php echo $article['id']; ?>">
                        <?php echo $article['auteur']; ?>
                        </a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posté le <?php echo $article['date'];?></p>
                    <hr>
                    <img class="img-responsive" src="/images/<?php echo $article['image'];?>"/>
                    <hr>
                    <p><?php echo $article['contenu'];?></p>
                <hr>
                <?php }
                ?>
        </div>
    </div>

    <!-- /.row -->
    <hr>
</div>
