/* DO NOT EDIT THIS FILE - it is machine generated */
#include <jni.h>
/* Header for class net_xp_framework_turpitude_PHPCompiledScript */

#ifndef _Included_net_xp_framework_turpitude_PHPCompiledScript
#define _Included_net_xp_framework_turpitude_PHPCompiledScript
#ifdef __cplusplus
extern "C" {
#endif
/*
 * Class:     net_xp_framework_turpitude_PHPCompiledScript
 * Method:    execute
 * Signature: (Ljavax/script/ScriptContext;)Ljava/lang/Object;
 */
JNIEXPORT jobject JNICALL Java_net_xp_1framework_turpitude_PHPCompiledScript_execute
  (JNIEnv *, jobject, jobject);

/*
 * Class:     net_xp_framework_turpitude_PHPCompiledScript
 * Method:    nativeInvokeFunction
 * Signature: (Ljava/lang/String;[Ljava/lang/Object;)Ljava/lang/Object;
 */
JNIEXPORT jobject JNICALL Java_net_xp_1framework_turpitude_PHPCompiledScript_nativeInvokeFunction
  (JNIEnv *, jobject, jstring, jobjectArray);

/*
 * Class:     net_xp_framework_turpitude_PHPCompiledScript
 * Method:    nativeInvokeMethod
 * Signature: (Ljava/lang/Object;Ljava/lang/String;[Ljava/lang/Object;)Ljava/lang/Object;
 */
JNIEXPORT jobject JNICALL Java_net_xp_1framework_turpitude_PHPCompiledScript_nativeInvokeMethod
  (JNIEnv *, jobject, jobject, jstring, jobjectArray);

/*
 * Class:     net_xp_framework_turpitude_PHPCompiledScript
 * Method:    createInstance
 * Signature: (Ljava/lang/String;)Ljava/lang/Object;
 */
JNIEXPORT jobject JNICALL Java_net_xp_1framework_turpitude_PHPCompiledScript_createInstance
  (JNIEnv *, jobject, jstring);

#ifdef __cplusplus
}
#endif
#endif