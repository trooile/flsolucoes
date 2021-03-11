<?php include "../include/include.php" ?>

<!DOCTYPE html>
    <html lang="pt">
        <div class="position-relative m-4">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <a role="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" href="create-account-step1.php" style="width: 2rem; height:2rem;">1</a>
            <a role="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-primary rounded-pill" href="create-account-step2.php" style="width: 2rem; height:2rem;">2</a>
            <a role="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" href="create-account-step3.php" style="width: 2rem; height:2rem;">3</a>
        </div>
        <div class="container">
            <button class="btn btn-primary btn-lg pull-right" type="submit">
                Next
            </button>
        </div>
    
    </html>
</html> 

<?php include "../include/footer.php" ?>