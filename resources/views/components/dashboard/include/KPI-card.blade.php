<div id="cards-container1" class="row">
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            fetchCardData1();
        });

        // Fetch card data
        function fetchCardData1() {
            $.ajax({
                url: "{{ url('get-cards') }}",
                method: 'GET',
                success: function(data) {
                    renderCards1(data);
                    initializeKpiCountAnimation1();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cards:', error);
                }
            });
        }

        // Render card HTML
        function renderCards1(data) {
            let cardsHtml = '';
            data.forEach(card => {
                cardsHtml += generateCardHtml1(card);
            });
            $('#cards-container1').html(cardsHtml);
        }

        // Generate individual card HTML
        function generateCardHtml1(card) {
            return `
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    ${card.title}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="${card.percentageClass} fs-14 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    ${card.percentage}
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="${card.value}">0</span>
                                </h4>
                                <a href="${card.linkUrl}" class="text-decoration-underline">${card.link}</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title ${card.iconBg} rounded fs-3">
                                    <i class="${card.icon} ${card.iconColor}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        // Initialize KPI count animation
        function initializeKpiCountAnimation1() {
            const counters = document.querySelectorAll(".counter-value");

            function formatNumber1(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            counters.forEach(counter => {
                animateCounter1(counter);
            });

            function animateCounter1(counter) {
                const target = +counter.getAttribute("data-target");
                let current = +counter.innerText;
                const increment = target / 250;

                function updateCounter1() {
                    current = Math.min(current + increment, target);
                    counter.innerText = formatNumber(Math.floor(current));
                    if (current < target) {
                        setTimeout(updateCounter, 1);
                    } else {
                        counter.innerText = formatNumber(target);
                    }
                }

                updateCounter1();
            }
        }
    </script>
@endpush
