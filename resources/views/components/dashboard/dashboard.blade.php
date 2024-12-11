<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xl-9">
                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <x-dashboard.include.greeting />
                        </div>
                    </div>
                    <x-dashboard.include.kpi-card />
                    <x-dashboard.include.chart />
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-3 col-sm-12 col-xl-3 d-lg-none d-xl-block">
                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="card h-100 rounded-0">
                                <div class="card-body p-0">
                                    <x-dashboard.include.user-activity :userLogs="$userLogs" :isEmployeeDashboard="true" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
