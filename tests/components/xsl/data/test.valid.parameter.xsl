<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.1">
    
    <xsl:param name="p1"/>
    
    <xsl:template match="/">
        <p><xsl:value-of select="$p1"/></p>
    </xsl:template>
    
</xsl:stylesheet>
