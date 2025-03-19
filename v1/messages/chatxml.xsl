<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <title>Chat Messages</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .message { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
                    .timestamp { color: #888; font-size: 0.9em; }
                    .user { font-weight: bold; }
                </style>
            </head>
            <body>
                <xsl:for-each select="messages/message">
                    <div class="message">
                        <div class="timestamp">
                            <xsl:value-of select="timestamp"/>
                        </div>
                        <div class="user">
                           <xsl:value-of select="user_id"/>: &nbsp; &nbsp;
                        </div>
                        <div class="content">
                            <xsl:value-of select="content"/>
                        </div>
                    </div>
                </xsl:for-each>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
