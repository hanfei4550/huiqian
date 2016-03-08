using UnityEngine;
using System.Collections;

public class SpriteCreateTool : MonoBehaviour {

	//根据图片转为sprite物体
//	public static GameObject SpriteCreate(Texture2D texture)
//	{
//		Rect rect=new Rect(0,0,texture.width,texture.height);
//		Vector2 pivot=new Vector2(0.5f,0.5f);
//		Sprite mSprite= Sprite.Create (texture,rect,pivot);
//		GameObject mSpriteObject=new GameObject();
//		SpriteRenderer mSpriteRenderer = mSpriteObject.AddComponent<SpriteRenderer>();
//		mSpriteRenderer.sprite = mSprite;
//		return mSpriteObject;
//	}
	//根据图片转为sprite
	public static Sprite SpriteCreate(Texture2D texture)
	{
		if(texture == null)
		{return null;}
		Rect rect=new Rect(0,0,texture.width,texture.height);
		Vector2 pivot=new Vector2(0.5f,0.5f);
		Sprite mSprite= Sprite.Create (texture,rect,pivot);
		return mSprite;
	}
}
