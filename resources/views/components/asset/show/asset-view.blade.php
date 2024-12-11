@props([
    'title' => '',
    'asset' => $asset,
])

<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="sticky-side-div">
                    <div class="card  shadow-none right">
                        <img src="{{ $asset->img ?? '' }}" alt="" class="img-fluid rounded w-75">
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-9">
                <div>
                    <div class="dropdown float-end">
                        <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ri-more-fill align-middle fs-16"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item view-item-btn" href="javascript:void(0);">
                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                    View
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item edit-item-btn" href="#!">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item remove-item-btn" href="#!">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"> </i>
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                    <h4>{{ $asset->name ?? '' }}</h4>
                    <div class="hstack gap-3 flex-wrap">
                        <div class="text-muted">Serial Number :
                            <a href="#" class="text-primary fw-medium">
                                {{ $asset->serial_number ?? '' }}
                            </a>
                        </div>
                        <div class="vr"></div>
                        <div class="text-muted">Issue Date : <span class="text-body fw-medium">
                                {{ date('Y-m-d', strtotime($asset->issue_date)) ?? '' }}
                            </span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded text-center">
                                <div>
                                    <p class="text-muted fw-medium mb-1">Condition :</p>
                                    <label class="text-success mb-0"><i class="mdi mdi-ethereum me-1"></i>
                                        {{ ucwords($asset->condition) ?? '' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded text-center">
                                <div>
                                    <p class="text-muted fw-medium mb-1">Category</p>
                                    <label class="mb-0">
                                        {{ ucwords($asset->category->name) ?? '' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded text-center">
                                <div>
                                    <p class="text-muted fw-medium mb-1">Status</p>
                                    <span class="badge bg-{{ isActive($asset->is_active, 'col') }} ">
                                        {{ isActive($asset->is_active, 'val') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded text-center">
                                <div>
                                    <p class="text-muted fw-medium mb-1">Duration</p>
                                    <label id="auction-time-1"
                                        class="mb-0">{{ duration($asset->issue_date, date('Y-m-d')) }}</label>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!--end row-->
                    <div class="mt-4 text-muted">
                        <h5 class="fs-14">Warrenty Information :</h5>
                        <p>Cultural patterns are the similar behaviors within similar situations we
                            witness due to shared beliefs, values, norms and social practices that
                            are steady over time. In art, a pattern is a repetition of specific
                            visual elements. The dictionary.com definition of "pattern" is: an
                            arrangement of repeated or corresponding parts, decorative motifs, etc.
                        </p>
                    </div>
                    <div class="product-content mt-1">
                        <nav>
                            <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-additional{{ $asset->id }}-tab"
                                        data-bs-toggle="tab" href="#nav-additional{{ $asset->id }}" role="tab"
                                        aria-controls="nav-additional{{ $asset->id }}"
                                        aria-selected="false">Additional Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-detail{{ $asset->id }}-tab" data-bs-toggle="tab"
                                        href="#nav-detail{{ $asset->id }}" role="tab"
                                        aria-controls="nav-detail{{ $asset->id }}" aria-selected="false">Details</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                            <div class="tab-pane active " id="nav-additional{{ $asset->id }}" role="tabpanel"
                                aria-labelledby="nav-additional{{ $asset->id }}-tab">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            @foreach ($asset->attributes as $key => $attribute)
                                                <tr>
                                                    <th scope="row" style="width: 200px;">{{ $attribute->name }}
                                                    </th>
                                                    <td>{{ $attribute->pivot->value ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-detail{{ $asset->id }}" role="tabpanel"
                                aria-labelledby="nav-detail{{ $asset->id }}-tab">
                                <div>
                                    <h5 class="font-size-16 mb-3">Patterns arts & culture</h5>
                                    <p>Cultural patterns are the similar behaviors within similar
                                        situations we witness due to shared beliefs, values, norms
                                        and social practices that are steady over time. In art, a
                                        pattern is a repetition of specific visual elements. The
                                        dictionary.com definition of "pattern" is: an arrangement of
                                        repeated or corresponding parts, decorative motifs, etc.</p>
                                    <div>
                                        <p class="mb-2"><i
                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                            On digital or printed media</p>
                                        <p class="mb-2"><i
                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                            For commercial and personal projects</p>
                                        <p class="mb-2"><i
                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                            From anywhere in the world</p>
                                        <p class="mb-0"><i
                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                            Full copyrights sale</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div>
                            <h5 class="fs-14 mb-3">Assets Tag</h5>
                        </div>
                        <div class="row gy-4 gx-0">
                            <div class="col-lg-4">
                                <div>
                                    <div class="pb-3">
                                        <div class="border border-dashed rounded p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-wrap gap-2 fs-15">
                                                    @php
                                                        $tags = [];
                                                        if ($asset->tags) {
                                                            $tags = explode(',', $asset->tags[0]);
                                                        }
                                                    @endphp
                                                    {{--  @foreach ($tags as $tag)
                                                        <a href="javascript:void(0);"
                                                            class="badge bg-primary-subtle text-primary">
                                                            {{ $tag }}
                                                        </a>
                                                    @endforeach --}}
                                                    @forelse  ($tags as $tag)
                                                        <a href="javascript:void(0);"
                                                            class="badge bg-primary-subtle text-primary">
                                                            {{ $tag }}
                                                        </a>
                                                    @empty
                                                        ffff
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-muted">Total <span class="fw-medium">7.32k</span> reviews
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">5 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 50.16%" aria-valuenow="50.16"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">2758</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">4 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 19.32%" aria-valuenow="19.32"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">1063</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">3 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 18.12%" aria-valuenow="18.12"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">997</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">2 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 7.42%" aria-valuenow="7.42"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">408</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">1 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: 4.98%" aria-valuenow="4.98"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">274</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-8">
                                <div class="ps-lg-4">
                                    <div class="d-flex flex-wrap align-items-start gap-3">
                                        <h5 class="fs-14">Reviews: </h5>
                                    </div>

                                    <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                        <ul class="list-unstyled mb-0">
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="text-warning">
                                                                <i class="mdi mdi-star"></i>
                                                                <i class="mdi mdi-star"></i>
                                                                <i class="mdi mdi-star"></i>
                                                                <i class="mdi mdi-star"></i>
                                                                <i class="mdi mdi-star"></i>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0"> Superb Artwork
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-grow-1 gap-2 mb-3">
                                                        <a href="#" class="d-block">
                                                            <img src="{{ asset('assets/images/small/img-12.jpg') }}"
                                                                alt=""
                                                                class="avatar-sm rounded object-fit-cover" />
                                                        </a>
                                                        <a href="#" class="d-block">
                                                            <img src="{{ asset('assets/images/small/img-11.jpg') }}"
                                                                alt=""
                                                                class="avatar-sm rounded object-fit-cover" />
                                                        </a>
                                                        <a href="#" class="d-block">
                                                            <img src="{{ asset('assets/images/small/img-10.jpg') }}"
                                                                alt=""
                                                                class="avatar-sm rounded object-fit-cover" />
                                                        </a>
                                                    </div>

                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Henry</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">12 Jul,
                                                                21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.0
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0"> Great at
                                                                    this price, Product quality and
                                                                    look is awesome.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Nancy</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">06 Jul,
                                                                21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.2
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0">Good
                                                                    product. I am so happy.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Joseph</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">06 Jul,
                                                                21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.1
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0">Nice
                                                                    Product, Good Quality.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Jimmy</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">24 Jun,
                                                                21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end Ratings & Reviews -->
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
