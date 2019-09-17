<section class="margin-y mb-5">
    <div class="row">
        <div class="col-md-7 offset-md-3 text-center">
            <!-- Default form contact -->
            <form class="text-center border border-light p-5" method="post" action="/contact">

                <p class="h4 mb-4">Contact us</p>

                <?php foreach ($GLOBALS["NOTIFIER"]->getNotifications() as $notification) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $notification; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Name -->
                <input type="text" id="name" class="form-control mb-4" placeholder="Name" name="name">

                <!-- Email -->
                <input type="email" id="email" class="form-control mb-4" placeholder="E-mail" name="email">

                <!-- Message -->
                <div class="form-group">
                    <textarea class="form-control rounded-0" id="message" rows="3" placeholder="Message" name="message"></textarea>
                </div>

                <!-- Copy -->
                <div class="custom-control custom-checkbox mb-4">
                    <input type="checkbox" class="custom-control-input" id="defaultContactFormCopy">
                    <label class="custom-control-label" for="defaultContactFormCopy">Send me a copy of this message</label>
                </div>

                <!-- Send button -->
                <button class="btn btn-info btn-block" type="submit">Send</button>

            </form>
            <!-- Default form contact -->
        </div>
    </div>
</section>