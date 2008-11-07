<?xml version="1.0" encoding="ISO-8859-1" ?>
<xsl:stylesheet
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:func="http://exslt.org/functions"
  xmlns:str="http://exslt.org/strings"
  xmlns:exsl="http://exslt.org/common"
  xmlns:docu="."
  extension-element-prefixes="func str"
  version="1.0"
>
  <xsl:output conent-type="text/html" />

  <xsl:template match="/documentation">
    <html>
      <head>
        <title><xsl:value-of select="/documentation/meta/name" /></title>
        <style type="text/css"><![CDATA[
          .func div {
            padding-bottom: 8px;
          }
          .func {
            padding-bottom: 10px;
          }
          ul {
            margin-top: 0;
            margin-bottom: 0;
          }
          h1, h2, h3, h4 {
            color: #7777ff;
          }
          h3 {
            margin-bottom: 0;
          }
          small {
            font-size: 90%;
          }
          .signature {
            border: 1px dashed black;
            padding: 5px 20px;
            background-color: #eeeeee;
            font-family: monospace;
            font-weight: bold;
          }
          .signature .return {
            color: darkred;
          }
          .signature .params .optional {
            font-style: italic;
            font-weight: normal;
          }
          .signature .params .type {
            color: darkred;
          }
          .signature .params .default {
            color: darkblue;
          }
        ]]></style>
      </head>
      <body>
        <h1><xsl:value-of select="/documentation/meta/name" /></h1>
        <xsl:for-each select="./function"><xsl:call-template name="function"/></xsl:for-each>
      </body>
    </html>
  </xsl:template>

  <xsl:template name="function">
    <div class="func" id="{@name}">
      <div class="func_head"><h3><xsl:value-of select="@name" /></h3></div>
      <div class="func_desc">
        <xsl:copy-of select="description/node()" />
      </div>
      <div class="signature">
        <code>
          <span class="return"><xsl:value-of select="docu:ifThenElse(return, return/@type, 'NULL')" />&#160;</span>
          <span class="name"><xsl:value-of select="@name" /></span>
          <span class="params">(
            <xsl:for-each select="parameters/parameter">
              <span class="param { docu:ifThenElse(@default, 'optional') }">
                <span class="type"><xsl:value-of select="@type" /></span>
                <span class="name">&#160;<xsl:value-of select="@name" /></span>
                <xsl:if test="@default">=<span class="default">&#160;<xsl:value-of select="@default" /></span></xsl:if>
              </span>
              <xsl:if test="not(position() = last())">, </xsl:if>
            </xsl:for-each>
          )</span>
        </code>
      </div>
      <xsl:if test="return">
        <div class="func_return"><b>return:</b>&#160;(<xsl:value-of select="return/@type"/>)&#160;<xsl:copy-of select="return/text()" /></div>
      </xsl:if>
      <xsl:if test="parameters/parameter">
        <div class="func_params">
          Parameters:
          <ul>
            <xsl:for-each select="parameters/parameter"><xsl:call-template name="function_param"/></xsl:for-each>
          </ul>
        </div>
      </xsl:if>
      <xsl:if test="tokens/token">
        <div class="func_tokens">
          Token-Stack:<ul>
            <xsl:for-each select="tokens/token">
              <li>
                <xsl:if test="@certain = 'FALSE'">?&#160;</xsl:if>
                <xsl:value-of select="@type" />:&#160;<xsl:value-of select="@name" />
              </li>
            </xsl:for-each>
          </ul>
        </div>
      </xsl:if>
      <xsl:if test="tokens/token[not(@certain = 'FALSE')]">
        <div class="func_see">
          See also:<xsl:text> </xsl:text>
          <xsl:for-each select="docu:collectByToken(.)">
            <xsl:call-template name="function_link" /><xsl:text> </xsl:text>
          </xsl:for-each>
        </div>
      </xsl:if>
      <div class="func_foot"><a href="#top">^Top</a></div>
    </div>
  </xsl:template>

  <xsl:template name="function_param">
    <li>
      <xsl:if test="@default"><b>?</b></xsl:if>
      (<xsl:value-of select="./@type"/>)&#160;<xsl:copy-of select="text()" />
      <xsl:if test="@default"><small><br />default value:&#160;<xsl:value-of select="@default" /></small></xsl:if>
    </li>
  </xsl:template>

  <xsl:template name="function_link">
    <a href="#{@name}"><xsl:value-of select="@name" /></a>
  </xsl:template>

  <func:function name="docu:getTokens">
    <xsl:param name="tokens" />
    <xsl:choose>
      <xsl:when test="count($tokens) = 0"><func:result select="/.." /></xsl:when>
      <xsl:otherwise><func:result select="str:tokenize($tokens[1]/@name, '|') | docu:getTokens($tokens[position() != 1])" /></xsl:otherwise>
    </xsl:choose>
  </func:function>

  <func:function name="docu:collectByToken">
    <xsl:param name="function" />
    <func:result select="docu:_collectByToken($function, $function)" />
  </func:function>

  <func:function name="docu:_collectByToken">
    <xsl:param name="functions" />
    <xsl:param name="collected" />
    <xsl:variable name="directResult" select="/documentation/function[not(@name = $collected/@name)][docu:getTokens(tokens/token) = docu:getTokens($functions/tokens/token[not(@certain = 'FALSE')])]" />
    <xsl:choose>
      <xsl:when test="count($functions) = 0"><func:result select="/.." /></xsl:when>
      <xsl:otherwise><func:result select="$directResult | docu:_collectByToken($directResult, $collected | $directResult)" /></xsl:otherwise>
    </xsl:choose>
  </func:function>

  <func:function name="docu:ifThenElse">
    <xsl:param name="cond" />
    <xsl:param name="then" />
    <xsl:param name="else" select="''" />
    <xsl:choose>
      <xsl:when test="$cond"><func:result select="$then" /></xsl:when>
      <xsl:otherwise><func:result select="$else" /></xsl:otherwise>
    </xsl:choose>
  </func:function>

</xsl:stylesheet>
