<?php extend('layouts/backend_layout') ?>

<?php section('content') ?>

<div class="container-fluid backend-page" id="calendar-page">
    <div class="row" id="calendar-toolbar">

        <div id="calendar-view" class="col-md-8">
            <?php if (can('add', PRIV_APPOINTMENTS)): ?>
                <div class="dropdown d-sm-inline-block">
                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-plus"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" id="insert-appointment">
                                <?= lang('appointment') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="insert-unavailability">
                                <?= lang('unavailability') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="insert-working-plan-exception" <?= session('role_slug') !== DB_SLUG_ADMIN ? 'hidden' : '' ?>>
                                <?= lang('working_plan_exception') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif ?>
            <div class="dropdown d-sm-inline-block">
                <button class="btn btn-light" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-eye"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= site_url('calendar?view=list') ?>">
                        <?= lang('list') ?>
                    </a>
                    <a class="dropdown-item" href="<?= site_url('calendar?view=timegrid') ?>">
                        <?= lang('table') ?>
                    </a>
                    <a class="dropdown-item" href="<?= site_url('calendar?view=default') ?>">
                        <?= lang('calendar') ?>
                    </a>
                </div>
            </div>
            <button id="reload-appointments" class="btn btn-light"
                    data-tippy-content="<?= lang('reload_appointments_hint') ?>">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <div id="calendar-date" class="col-md-8">
	    <button id="previous-day" class="btn btn-light"
                    data-tippy-content="<?= lang('previous day') ?>">
                <i class="fas fa-chevron-left"></i>
            </button>
	    <input id="select-date" type="text" class="form-control d-inline-block select-date">
	    <button id="next-day" class="btn btn-light"
		    data-tippy-content="<?= lang('next day') ?>">
		<i class="fas fa-chevron-right"></i>
            </button>
	    <button id="today" class="btn btn-light"><?= lang('today') ?>
            </button>
        </div>

        <div id="calendar-filter" class="col-md-4">
            <div class="calendar-filter-items">
                <select id="select-filter-item" class="form-control col"
                        data-tippy-content="<?= lang('select_filter_item_hint') ?>">
                </select>
            </div>
        </div>

    </div>

    <div id="calendar">
        <!-- Dynamically Generated Content -->
    </div>
</div>

<!-- Page Components -->

<?php component(
    'appointments_modal',
    [
        'available_services' => vars('available_services'),
        'appointment_status_options' => vars('appointment_status_options'),
        'timezones' => vars('timezones'),
        'require_first_name' => vars('require_first_name'),
        'require_last_name' => vars('require_last_name'),
        'require_email' => vars('require_email'),
        'require_phone_number' => vars('require_phone_number'),
        'require_address' => vars('require_address'),
        'require_city' => vars('require_city'),
        'require_zip_code' => vars('require_zip_code')
    ]
) ?>

<?php component(
    'unavailabilities_modal',
    [
        'timezones' => vars('timezones'),
        'timezone' => vars('timezone')
    ]
) ?>

<?php component('select_google_calendar_modal') ?>

<?php component('working_plan_exceptions_modal') ?>

<?php end_section('content') ?>

<?php section('scripts') ?>

<script src="<?= asset_url('assets/vendor/fullcalendar/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/fullcalendar-moment/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/jquery-jeditable/jquery.jeditable.min.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/date.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/ui.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_default_view.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_table_view.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_google_sync.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_event_popover.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/calendar_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/google_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/customers_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/calendar.js') ?>"></script>

<?php end_section('scripts') ?>

