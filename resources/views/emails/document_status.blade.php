<x-mail::message>
# Document Status Update

Your request for **{{ $documentType }}** has been updated.

**Status:** {{ $documentStatus }}

@if($documentStatus === 'Approved')
We are happy to inform you that your request is approved! You can claim it at the barangay office. <br>
Please bring a valid ID to claim your document. 
This is valid for 3 days after approval. If the document is not claimed within this period, you will need to reapply.
@elseif($documentStatus === 'Rejected')
We regret to inform you that your request was rejected. Due to {{ $rejectingReason }}. If you have any questions, please contact us. Or you can reapply for the document.
@else
Your request is currently pending. We will notify you once it is processed.
@endif

Thanks,<br>
Barangay Lawang Bato
</x-mail::message>
