<?php include "../include/include.php" ?>

<!DOCTYPE html>
    <html lang="pt">
        <div class="position-relative m-4">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <a role="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" href="create-account-step1.php" style="width: 2rem; height:2rem;">1</a>
            <a role="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-secondary rounded-pill" href="create-account-step2.php" style="width: 2rem; height:2rem;">2</a>
            <a role="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" href="create-account-step3.php" style="width: 2rem; height:2rem;">3</a>
        </div>
        <div class="container">
            <form class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationCustom01">First name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name" required>
                        <div class="valid-feedback">
                            Good!
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid First name.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationCustom02">Last name</label>
                        <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" required>
                        <div class="valid-feedback">
                            Good!
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid Last name.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationCustomUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
                            <div class="valid-feedback">
                                Username valid.
                            </div>
                            <div class="invalid-feedback">
                                Please choose a username.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom03">City</label>
                        <input type="text" class="form-control" id="validationCustom03" placeholder="City" required>
                        <div class="valid-feedback">
                                Valid city.
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">State</label>
                        <input type="text" class="form-control" id="validationCustom04" placeholder="State" required>
                        <div class="valid-feedback">
                                Valid state.
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom05">Zip</label>
                        <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required>
                        <div class="valid-feedback">
                                Valid Zip.
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check pull-right">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <br></br>
                <button class="btn btn-primary btn-lg pull-right" type="submit">
                    Next
                </button>
            </form>
        </div>
    </html>
</html>


<?php include "../include/footer.php" ?>

<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {

    var forms = document.getElementsByClassName('needs-validation');

    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
        form.classList.add('was-validated');
        }, false);
    });
    }, false);
})();
</script>