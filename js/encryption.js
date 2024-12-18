const encryptionKey = 'client_side_key';

async function encryptMessage(message) {
    const encoder = new TextEncoder();
    const data = encoder.encode(message);
    const key = await crypto.subtle.importKey('raw', encoder.encode(encryptionKey), 'AES-GCM', false, ['encrypt']);
    const iv = crypto.getRandomValues(new Uint8Array(12));
    const encrypted = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, data);
    return { encrypted: btoa(String.fromCharCode.apply(null, new Uint8Array(encrypted))), iv: btoa(String.fromCharCode.apply(null, iv)) };
}

async function decryptMessage(encryptedMessage, iv) {
    const decoder = new TextDecoder();
    const key = await crypto.subtle.importKey('raw', encoder.encode(encryptionKey), 'AES-GCM', false, ['decrypt']);
    const decrypted = await crypto.subtle.decrypt({ name: 'AES-GCM', iv: Uint8Array.from(atob(iv), c => c.charCodeAt(0)) }, key, Uint8Array.from(atob(encryptedMessage), c => c.charCodeAt(0)));
    return decoder.decode(decrypted);
}
