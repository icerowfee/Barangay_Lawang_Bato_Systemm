<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Center Report</title>
    <style>
        @page {
            margin: 120px 50px 80px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #ffffff;
            color: #333;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        header img {
            height: 60px;
            margin-top: 10px;
        }

        header h1 {
            margin: 5px 0 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 12px;
            text-align: center;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .container {
            max-width: 800px;
            margin: auto;

        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-left: 4px solid #000;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        /* .card-holder {
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            justify-content: space-between;
            gap: 16px;
        } */

        .card {
            border: 1px solid #ccc;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .label {
            font-size: 10px;
            color: #666;
        }

        .value {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        .value.blue { color: #1f77b4; }
        .value.yellow { color: #ffbb00; }
        .value.green { color: #2ca02c; }
        .value.red { color: #d62728; }
    </style>
</head>
<body>

@if ($moduleFilter == 'all')

    <header>
        <img src="{{ public_path('images/lawang-bato-logo.png') }}" alt="Barangay Lawang Bato">
        <h1>Overall Report</h1>
    </header>

    <div class="container">
        <h5>Admin Accounts as of <strong>{{ \Carbon\Carbon::now()->format('F j, Y') }}</strong>.</h5>
        <!-- Cedula Issuance Section -->
        <div class="section">
            <div class="section-title">Admin Account Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Admin Accounts</div>
                    <div class="value blue">{{$totalAdminAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Total Document Issuance Admin</div>
                    <div class="value yellow">{{$totalDocumentIssuanceAdmins}}</div>
                </div>
                <div class="card">
                    <div class="label">Total Job Center Admin</div>
                    <div class="value green">{{$totalJobCenterAdmins}}</div>
                </div>
            </div>
        </div>

        @if ($dateStart && $dateEnd)
            <h5>Report from <strong>{{$dateStart}}</strong> to <strong>{{$dateEnd}}</strong>.</h5>
        @else
            <h5>Report as of <strong>{{ \Carbon\Carbon::now()->format('F j, Y')}}</strong>.</h5>
        @endif
        <!-- Cedula Issuance Section -->
        <div class="section">
            <div class="section-title">Cedula Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Cedula Issued</div>
                    <div class="value blue">{{$totalIssuedCedula}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Cedula Requests</div>
                    <div class="value yellow">{{$totalPendingCedulaRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Cedula Requests</div>
                    <div class="value green">{{$totalApprovedCedulaRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Cedula Requests</div>
                    <div class="value red">
                        {{$totalRejectedCedulaRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Clearance Issuance Section -->
        <div class="section">
            <div class="section-title">Clearance Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Clearance Issued</div>
                    <div class="value blue">{{$totalIssuedCearances}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Clearance Requests</div>
                    <div class="value yellow">{{$totalPendingClearanceRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Clearance Requests</div>
                    <div class="value green">{{$totalApprovedClearanceRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Clearance Requests</div>
                    <div class="value red">
                        {{$totalRejectedClearanceRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Indigency Issuance Section -->
        <div class="section">
            <div class="section-title">Indigency Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Indigency Issued</div>
                    <div class="value blue">{{$totalIssuedIndigency}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Indigency Requests</div>
                    <div class="value yellow">{{$totalPendingIndigencyRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Indigency Requests</div>
                    <div class="value green">{{$totalApprovedIndigencyRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Indigency Requests</div>
                    <div class="value red">
                        {{$totalRejectedIndigencyRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Referral Section -->
        <div class="section">
            <div class="section-title">Job Referral Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Job Referred</div>
                    <div class="value blue">{{$totalJobReferred}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Job Referral Requests</div>
                    <div class="value yellow">{{$totalPendingJobReferralRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Processing Job Referral Requests</div>
                    <div class="value green">{{$totalProcessingJobReferralRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected / Cancelled Job Referral Requests</div>
                    <div class="value red">
                        {{$totalRejectedAndCancelledJobReferralRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Account Section -->
        <div class="section">
            <div class="section-title">Job Accounts Summary</div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Active Job Accounts</div>
                    <div class="value blue">{{$totalActiveJobAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Job Accounts</div>
                    <div class="value yellow">{{$totalPendingJobAccounts}}</div>
                </div>
            </div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Accepted Job Accounts</div>
                    <div class="value green">{{$totalDeactivatedJobAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Job Accounts</div>
                    <div class="value red">{{$totalRejectedJobAccounts}}</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        Generated on {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }} &nbsp;|&nbsp; {{$superAdminFirstname . ' ' . $superAdminLastname}} &nbsp;|&nbsp; Super Admin
        {{-- Page numbers: Add manually via script if needed --}}
    </footer>


@elseif ($moduleFilter == 'super_admin_module')

    <header>
        <img src="{{ public_path('images/lawang-bato-logo.png') }}" alt="Barangay Lawang Bato">
        <h1>Admin Account Report</h1>
    </header>

    <div class="container">
        <h5>Admin Accounts as of <strong>{{ \Carbon\Carbon::now()->format('F j, Y') }}</strong>.</h5>
        <!-- Cedula Issuance Section -->
        <div class="section">
            <div class="section-title">Admin Account Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Admin Accounts</div>
                    <div class="value blue">{{$totalAdminAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Total Document Issuance Admin</div>
                    <div class="value yellow">{{$totalDocumentIssuanceAdmins}}</div>
                </div>
                <div class="card">
                    <div class="label">Total Job Center Admin</div>
                    <div class="value green">{{$totalJobCenterAdmins}}</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        Generated on {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }} &nbsp;|&nbsp; {{$superAdminFirstname . ' ' . $superAdminLastname}} &nbsp;|&nbsp; Super Admin
        {{-- Page numbers: Add manually via script if needed --}}
    </footer>

@elseif ($moduleFilter == 'document_issuance_module')    
        
    <header>
        <img src="{{ public_path('images/lawang-bato-logo.png') }}" alt="Barangay Lawang Bato">
        <h1>Document Issuance Report</h1>
    </header>

    <div>
        @if ($dateStart && $dateEnd)
            <h5>Report from <strong>{{$dateStart}}</strong> to <strong>{{$dateEnd}}</strong>.</h5>
        @else
            <h5>Report as of <strong>{{ \Carbon\Carbon::now()->format('F j, Y')}}</strong>.</h5>
        @endif
        <!-- Cedula Issuance Section -->
        <div class="section">
            <div class="section-title">Cedula Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Cedula Issued</div>
                    <div class="value blue">{{$totalIssuedCedula}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Cedula Requests</div>
                    <div class="value yellow">{{$totalPendingCedulaRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Cedula Requests</div>
                    <div class="value green">{{$totalApprovedCedulaRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Cedula Requests</div>
                    <div class="value red">
                        {{$totalRejectedCedulaRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Clearance Issuance Section -->
        <div class="section">
            <div class="section-title">Clearance Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Clearance Issued</div>
                    <div class="value blue">{{$totalIssuedCearances}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Clearance Requests</div>
                    <div class="value yellow">{{$totalPendingClearanceRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Clearance Requests</div>
                    <div class="value green">{{$totalApprovedClearanceRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Clearance Requests</div>
                    <div class="value red">
                        {{$totalRejectedClearanceRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Indigency Issuance Section -->
        <div class="section">
            <div class="section-title">Indigency Issuance Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Indigency Issued</div>
                    <div class="value blue">{{$totalIssuedIndigency}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Indigency Requests</div>
                    <div class="value yellow">{{$totalPendingIndigencyRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Approved Indigency Requests</div>
                    <div class="value green">{{$totalApprovedIndigencyRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Indigency Requests</div>
                    <div class="value red">
                        {{$totalRejectedIndigencyRequests}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        Generated on {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }} &nbsp;|&nbsp; {{$superAdminFirstname . ' ' . $superAdminLastname}} &nbsp;|&nbsp; Super Admin
        {{-- Page numbers: Add manually via script if needed --}}
    </footer>

@elseif ($moduleFilter == 'job_center_module')
    <header>
        <img src="{{ public_path('images/lawang-bato-logo.png') }}" alt="Barangay Lawang Bato">
        <h1>Job Center Report</h1>
    </header>

    <div>
        @if ($dateStart && $dateEnd)
            <h5>Report from <strong>{{$dateStart}}</strong> to <strong>{{$dateEnd}}</strong>.</h5>
        @else
            <h5>Report as of <strong>{{ \Carbon\Carbon::now()->format('F j, Y')}}</strong>.</h5>
        @endif
        <!-- Job Referral Section -->
        <div class="section">
            <div class="section-title">Job Referral Summary</div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Total Job Referred</div>
                    <div class="value blue">{{$totalJobReferred}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Job Referral Requests</div>
                    <div class="value yellow">{{$totalPendingJobReferralRequests}}</div>
                </div>
            </div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Processing Job Referral Requests</div>
                    <div class="value green">{{$totalProcessingJobReferralRequests}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected / Cancelled Job Referral Requests</div>
                    <div class="value red">
                        {{$totalRejectedAndCancelledJobReferralRequests}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Account Section -->
        <div class="section">
            <div class="section-title">Job Accounts Summary</div>

            <div class="card-holder">
                <div class="card">
                    <div class="label">Active Job Accounts</div>
                    <div class="value blue">{{$totalActiveJobAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Pending Job Accounts</div>
                    <div class="value yellow">{{$totalPendingJobAccounts}}</div>
                </div>
            </div>
            <div class="card-holder">
                <div class="card">
                    <div class="label">Accepted Job Accounts</div>
                    <div class="value green">{{$totalDeactivatedJobAccounts}}</div>
                </div>
        
                <div class="card">
                    <div class="label">Rejected Job Accounts</div>
                    <div class="value red">{{$totalRejectedJobAccounts}}</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        Generated on {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }} &nbsp;|&nbsp; {{$superAdminFirstname . ' ' . $superAdminLastname}} &nbsp;|&nbsp; Super Admin
        {{-- Page numbers: Add manually via script if needed --}}
    </footer>

@endif


</body>
</html>
