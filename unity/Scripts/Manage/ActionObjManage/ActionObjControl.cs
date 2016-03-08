using UnityEngine;
using System.Collections;

public class ActionObjControl : MonoBehaviour {
	float rotaSpeed = 10;
	bool IsRotaSpeed = false;
	// Use this for initialization
//	void Start () {
//	
//	}
	
	// Update is called once per frame
	void Update () {
		RunTota();
	}
	void RunTota()
	{   
		if(!IsRotaSpeed){return;}
		transform.Rotate( Vector3.up*rotaSpeed*Time.deltaTime );
	}
	public void SetRotaSpeed(float speed )
	{  rotaSpeed = speed; }
	public void TurnOnRota(float speed)
	{
		rotaSpeed = speed;
		IsRotaSpeed = true;
	}
	public void TurnOffRota() 
	{
		IsRotaSpeed = false;
	}
}
