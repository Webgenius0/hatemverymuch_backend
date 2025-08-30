@extends('admin.layouts.app')

@push('css')
@endpush

@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="container-fluid">

                    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                        <h3>Contact Messages</h3>
                        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                            <li><a href="{{ route('contact.index') }}">
                                    <div class="text-tiny">Dashboard</div>
                                </a></li>
                            <li><i class="icon-chevron-right"></i></li>
                            <li>
                                <div class="text-tiny">Contact Messages</div>
                            </li>
                        </ul>
                    </div>

                    <div class="wg-box">
                        <!-- Filter & Search -->
                        <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                            <form class="flex items-center gap10 flex-wrap" method="GET"
                                action="{{ route('contact.index') }}">
                                <div class="wg-filter flex-grow flex items-center gap10">
                                    <div class="show flex items-center gap5">
                                        <div class="text-tiny">Showing</div>
                                        <select name="per_page" onchange="this.form.submit()">
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20
                                            </option>
                                            <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30
                                            </option>
                                        </select>
                                        <div class="text-tiny">entries</div>
                                    </div>
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." name="search"
                                            value="{{ request('search') }}">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="wg-table table-all-category">

                            <!-- Table Header -->
                            <ul class="table-title flex gap20 mb-14">
                                <li>
                                    <div class="body-title">Name</div>
                                </li>
                                <li>
                                    <div class="body-title">Email</div>
                                </li>
                                <li>
                                    <div class="body-title">Subject</div>
                                </li>
                                <li>
                                    <div class="body-title">Message</div>
                                </li>
                                <li>
                                    <div class="body-title">Sent At</div>
                                </li>
                                <li>
                                    <div class="body-title">Action</div>
                                </li>
                            </ul>

                            <!-- Table Body -->
                            <ul class="flex flex-column">
                                @forelse($contacts as $contact)
                                    <li class="product-item gap14">
                                        <div class="flex items-center justify-between gap20 flex-grow">
                                            <div class="name body-text">{{ $contact->first_name }} {{ $contact->last_name }}
                                            </div>
                                            <div class="body-text">{{ $contact->email }}</div>
                                            <div class="body-text">{{ $contact->subject }}</div>
                                            <div class="body-text">{{ Str::limit($contact->message, 50) }}</div>
                                            <div class="body-text">{{ $contact->created_at->format('d M Y') }}</div>
                                            <div class="list-icon-function flex gap10">
                                                <div class="item eye">
                                                    <a href="{{ route('contact.show', $contact->id) }}"><i class="icon-eye"></i></a>
                                                </div>
                                                <div class="item trash">
                                                    <form action="{{ route('contact.destroy', $contact->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"><i class="icon-trash-2"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="product-item gap14">
                                        <div class="flex items-center justify-center body-text">
                                            No contact messages found.
                                        </div>
                                    </li>
                                @endforelse
                            </ul>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $contacts->appends(request()->all())->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
