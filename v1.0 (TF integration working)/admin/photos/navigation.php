<nav>
    <?php
    $nb_max_elements_page = isset($_GET['nb_max']) ? $_GET['nb_max'] : $options['nb_max'];
    $page = isset($_GET['page']) ? ($_GET['page'] - 1) : 0;
    $debut = $nb_max_elements_page * $page;
    $fin = $debut + $nb_max_elements_page;
    $recherche = (isset($_GET['recherche'])) ? $_GET['recherche'] : null;

    $sql = "SELECT COUNT(id_photo) as nb_max FROM " . $himage_table;
    if ($recherche != NULL) {
         $sql .= " WHERE nom LIKE '%" . $recherche . "%'";
         $param_recherhe = '&recherche=' . $recherche;
    } else {
         $param_recherhe = '';
    }

    $stmt = $pdo->query($sql);
    $data = $stmt->fetch();
    $nb_max_elements = $data['nb_max'];
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $nb_max_page = ceil($nb_max_elements / $nb_max_elements_page);
    if ($nb_max_page > 1) {
         ?>
         <ul class="pagination row">
             <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
             <?php
             for ($i = 0; $i < $nb_max_page; $i++) {
                  $active = ($page == $i) ? 'class="active"' : '';

                  echo '<li ' . $active . '><a href="?page=' . ($i) . '&nb_max=' . $nb_max_elements_page . $param_recherhe . '&sort=' . $sort . '">' . ($i + 1) . '</a></li>';
             }
             ?>
             <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
         </ul>
    <?php } ?>
</nav>