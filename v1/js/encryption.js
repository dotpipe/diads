class ClientEncryption {
    constructor() {
        this.publicKey = null;
    }

    setPublicKey(key) {
        this.publicKey = key;
    }

    async encrypt(message) {
        const encoder = new TextEncoder();
        const data = encoder.encode(message);
        const encryptedData = await window.crypto.subtle.encrypt(
            {
                name: "RSA-OAEP"
            },
            await this.importPublicKey(),
            data
        );
        return btoa(String.fromCharCode.apply(null, new Uint8Array(encryptedData)));
    }

    async importPublicKey() {
        return await window.crypto.subtle.importKey(
            "spki",
            this.pemToArrayBuffer(this.publicKey),
            {
                name: "RSA-OAEP",
                hash: "SHA-256"
            },
            true,
            ["encrypt"]
        );
    }

    pemToArrayBuffer(pem) {
        const b64 = pem.replace(/-----BEGIN PUBLIC KEY-----|-----END PUBLIC KEY-----|\n|\r/g, '');
        const binary = window.atob(b64);
        const arr = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) {
            arr[i] = binary.charCodeAt(i);
        }
        return arr.buffer;
    }
}
