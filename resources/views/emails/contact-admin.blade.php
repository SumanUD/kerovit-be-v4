<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; border: 1px solid #ddd;">
    <p style="font-size: 18px; font-weight: bold; color: #333;">📩 You have received a new contact message:</p>
    <ul style="list-style: none; padding: 0; font-size: 16px; color: #555;">
        <li style="margin-bottom: 10px;"><strong>Name:</strong> {{ $contact->name }}</li>
        <li style="margin-bottom: 10px;"><strong>Email:</strong> {{ $contact->email }}</li>
        <li style="margin-bottom: 10px;"><strong>Phone:</strong> {{ $contact->phone }}</li>
        <li style="margin-bottom: 10px;"><strong>State:</strong> {{ $contact->state }}</li>
        <li style="margin-bottom: 10px;"><strong>City:</strong> {{ $contact->city }}</li>
        <li style="margin-bottom: 10px;"><strong>Message:</strong> {{ $contact->message }}</li>
    </ul>
</div>
