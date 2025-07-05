<div style="font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; border: 1px solid #ddd; color: #333;">
    <p style="font-size: 16px;">Hi <strong>{{ $contact->name }}</strong>,</p>

    <p style="font-size: 16px;">Thanks for contacting us. We’ve received your message and will get back to you shortly.</p>

    <hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">

    <p style="font-size: 16px;"><strong>Your Message:</strong><br>
    <span style="display: inline-block; margin-top: 10px; background: #f5f5f5; padding: 10px; border-radius: 5px;">{{ $contact->message }}</span></p>
</div>
