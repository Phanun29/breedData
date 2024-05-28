<div id="paginationSection">
    <div class="d-flex justify-content-center mt-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>

                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                    echo '</li>';
                }
                ?>

                <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>